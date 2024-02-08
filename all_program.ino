#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include "HX711.h"

#include<SoftwareSerial.h>
SoftwareSerial SUART(2, 3);//SRX = DPin-2, STX = DPin-3

#define calibration_factor -12200.0 //This value is obtained using the SparkFun_HX711_Calibration sketch
#define LOADCELL_DOUT_PIN  4
#define LOADCELL_SCK_PIN  5
const int pingPin = 6;
int inPin = 7;

float weight,duration,height;

LiquidCrystal_I2C lcd(0x27, 16, 2);
HX711 scale;

void setup() {
  Serial.begin(9600);  
  SUART.begin(9600);
  pinMode(pingPin, OUTPUT);
  pinMode(inPin, INPUT);
  pinMode(3, INPUT);
  pinMode(2, OUTPUT);

  lcd.begin();
  lcd.backlight();

  // scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);
  // scale.set_scale(calibration_factor); //This value is obtained by using the SparkFun_HX711_Calibration sketch
  // scale.tare(); //Assuming there is no weight on the scale at start up, reset the scale to 0
}

void loop() {
  // loadcell();
  delay(500);
  ultrasonic();
  delay(500);
  // lcd.setCursor(0,0);
  // lcd.print(weight);
  // lcd.setCursor(0,1);
  // lcd.print(height);
  SUART.print(weight);
  SUART.print(height);
  delay(100);
  // Serial.print("weight");
  // Serial.println(weight);
  // Serial.print("height");
  // Serial.println(height);

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