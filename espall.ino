/*
  Rui Santos
  Complete project details at Complete project details at https://RandomNerdTutorials.com/esp8266-nodemcu-http-get-post-arduino/

  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files.
  The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
  
  Code compatible with ESP8266 Boards Version 3.0.0 or above 
  (see in Tools > Boards > Boards Manager > ESP8266)
*/
#include <Arduino.h>
#include <ArduinoJson.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Adafruit_Fingerprint.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include "HX711.h"

#if (defined(__AVR__) || defined(ESP8266)) && !defined(__AVR_ATmega2560__)
// For UNO and others without hardware serial, we must use software serial...
// pin #2 is IN from sensor (GREEN wire)
// pin #3 is OUT from arduino  (WHITE wire)
// Set up the serial port to use softwareserial..
SoftwareSerial mySerial(5, 4);

#else
// On Leonardo/M0/etc, others with hardware serial, use hardware serial!
// #0 is green wire, #1 is white
#define mySerial Serial1

#endif

Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

#define calibration_factor -12200.0 //This value is obtained using the SparkFun_HX711_Calibration sketch
#define LOADCELL_DOUT_PIN  4
#define LOADCELL_SCK_PIN  5
const int pingPin = 6;
int inPin = 7;

float weight,duration,height;

LiquidCrystal_I2C lcd(0x27, 16, 2);
HX711 scale;

uint8_t id;

String url;
String payload;
String weight;
String height;
String status;
uint8_t in;
int st_finger;
int value = 0;
int finger_id;

const char* ssid = "tt";
const char* password = "12345678";


// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Timer set to 10 minutes (600000)
//unsigned long timerDelay = 600000;
// Set timer to 5 seconds (5000)
unsigned long timerDelay = 5000;

void setup() {
  Serial.begin(9600); 

  pinMode(pingPin, OUTPUT);
  pinMode(inPin, INPUT);

  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println(WiFi.localIP());

  while (!Serial); 
  delay(100);
  Serial.println("\n\nAdafruit Fingerprint sensor enrollment");
  finger.begin(57600);

  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);
  scale.set_scale(calibration_factor); //This value is obtained by using the SparkFun_HX711_Calibration sketch
  scale.tare(); //Assuming there is no weight on the scale at start up, reset the scale to 0
  
}

void loop() {

    getFingerprintIDez();
    delay(1000);
    checkfingerprint();
    delay(1000);
    send_status();
    delay(1000);
    getfingerID();
    delay(1000);
      Serial.print("in out:");
      Serial.println(in);
      Serial.print("st_finger out:");
      Serial.println(st_finger);
      Serial.print("Value:");
      Serial.println(value);
      Serial.print("finger_id:");
      Serial.println(finger_id);
    delay(1000);
    if(st_finger == 1){
      id = in;
      while (!  getFingerprintEnroll() );
      delay(2000);
      if(value == 1){
        url = "0";
        sucsuess_finger(url);
      }
      delay(1000);
    }else if(st_finger == 2){
      id = in;
      deleteFingerprint(id);
      delay(2000);
      if(value == 1){
        url = "1";
        sucsuess_finger(url);
      }
      delay(1000);
    }else{
    }
    if(finger_id != 0){
        fingerID_H_W();
        delay(1000);
        finger_id = 0;
        fingerID_H_W();
      }
    delay(1000);
}
void send_status(){
  // Send an HTTP POST request depending on timerDelay

    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){

      WiFiClient client;
      HTTPClient http;
      String serverName = "http://192.168.20.159/project/get_arduino.php";
      String serverPath = serverName + "?status=" + status;
      
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
  
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      // if (httpResponseCode>0) {
      //   Serial.print("HTTP Response code: ");
      //   Serial.println(httpResponseCode);
      //   String payload = http.getString();
      //   Serial.println(payload);
      // }
      // else {
      //   Serial.print("Error code: ");
      //   Serial.println(httpResponseCode);
      // }
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }

  
}
void getfingerID(){
  // Send an HTTP POST request depending on timerDelay

    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      WiFiClient client;
      HTTPClient http;
      String serverName = "http://192.168.20.159/project/addfingerprint.php";
      String serverPath = serverName;
      
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
  
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        payload = http.getString();
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        String RT = doc["RT_ID"];
        in = RT.toInt();

        String status_finger = doc["status_finger"];
        st_finger = status_finger.toInt();
        Serial.print("in:");
        Serial.println(in);
        Serial.print("st_finger:");
        Serial.println(st_finger);
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }

  }

void checkfingerprint(){
    if (finger.verifyPassword()) {
    status = "1";//เจอตัวสแกนนิ้ว
  } else {
    status = "2";//ไม่เจอตัวสแกน
  }
}
uint8_t getFingerprintEnroll() {

  int p = -1;
  Serial.print("Waiting for valid finger to enroll as #"); Serial.println(id);
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.println(".");
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      break;
    default:
      Serial.println("Unknown error");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.println("Remove finger");
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(id);
  p = -1;
  Serial.println("Place same finger again");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image taken");
      break;
    case FINGERPRINT_NOFINGER:
      Serial.print(".");
      break;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      break;
    case FINGERPRINT_IMAGEFAIL:
      Serial.println("Imaging error");
      break;
    default:
      Serial.println("Unknown error");
      break;
    }
  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  Serial.print("Creating model for #");  Serial.println(id);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  Serial.print("ID "); Serial.println(id);
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    value = 1;
    Serial.println("Stored!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  return true;
}
void sucsuess_finger(String url){
  // Send an HTTP POST request depending on timerDelay
  Serial.print("update");

    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){

      WiFiClient client;
      HTTPClient http;
      String serverName = "http://192.168.20.159/project/setstatusfinger.php";
      String serverPath = serverName + "?status_finger=" + "0" + "&RT_ID=" + "0" + "&del_or_add=" + url;
      
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
  
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      // if (httpResponseCode>0) {
      //   Serial.print("HTTP Response code: ");
      //   Serial.println(httpResponseCode);
      //   String payload = http.getString();
      //   Serial.println(payload);
      // }
      // else {
      //   Serial.print("Error code: ");
      //   Serial.println(httpResponseCode);
      // }
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
    value = 0;
}
uint8_t deleteFingerprint(uint8_t id) {
  uint8_t p = -1;

  p = finger.deleteModel(id);

  if (p == FINGERPRINT_OK) {
    Serial.println("Deleted!");
    value = 1;
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not delete in that location");
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
  } else {
    Serial.print("Unknown error: 0x"); Serial.println(p, HEX);
  }
  return 0;

}
int getFingerprintIDez() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.image2Tz();
  if (p != FINGERPRINT_OK)  return -1;

  p = finger.fingerFastSearch();
  if (p != FINGERPRINT_OK)  return -1;

  // found a match!
   finger_id = finger.fingerID;

  return finger.fingerID;
}
void fingerID_H_W(){
  // Send an HTTP POST request depending on timerDelay
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      weight = 58;
      height = 145;
      WiFiClient client;
      HTTPClient http;
      String serverName = "http://192.168.20.159/project/get_w_h_id.php";
      String serverPath = serverName + "?finger_id=" + finger_id + "&weight=" + weight + "&height=" + height;
      
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
  
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      // if (httpResponseCode>0) {
      //   Serial.print("HTTP Response code: ");
      //   Serial.println(httpResponseCode);
      //   String payload = http.getString();
      //   Serial.println(payload);
      // }
      // else {
      //   Serial.print("Error code: ");
      //   Serial.println(httpResponseCode);
      // }
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }

}
void loadcell(){
  weight = scale.get_units(),1; //scale.get_units() returns a float
  weight = weight * 0.45;
}
void ultrasonic(){

  digitalWrite(pingPin, LOW);
  delayMicroseconds(2);
  digitalWrite(pingPin, HIGH);
  delayMicroseconds(5);
  digitalWrite(pingPin, LOW);
  duration = pulseIn(inPin, HIGH);
  height = microsecondsToCentimeters(duration);
  delay(100);
}
long microsecondsToCentimeters(long microseconds){
return microseconds / 29 / 2;
}