// Import the Liquid Crystal library
#include <LiquidCrystal.h>
//Initialise the LCD with the arduino. LiquidCrystal(rs, enable, d4, d5, d6, d7)
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);
int incomingByte;
const int ledIn = 8;
const int ledFailure = 7;
const int ledOut = 6;

void setup() {
  // Switch on the LCD screen
  Serial.begin(9600);
  lcd.begin(16, 2);
  pinMode(ledIn,OUTPUT);
  pinMode(ledOut,OUTPUT);
  pinMode(ledFailure,OUTPUT);
}

void loop() {
  if (Serial.available() > 0) {
    incomingByte = Serial.read();
    if (incomingByte == 'A') {
      digitalWrite(ledOut,HIGH);
    }
    if (incomingByte == 'B') {
      digitalWrite(ledIn,HIGH);
    }
    if (incomingByte == 'C') {
      digitalWrite(ledFailure,HIGH);
      lcd.print("Swipe Error");
    }
    if (incomingByte == 'D') {
      digitalWrite(ledFailure,HIGH);
      lcd.print("Form Empty");
    }
    if (incomingByte == 'E') {
      digitalWrite(ledFailure,LOW);
      digitalWrite(ledOut,LOW);
      digitalWrite(ledIn,LOW);
      lcd.clear();
    }
  }
}
