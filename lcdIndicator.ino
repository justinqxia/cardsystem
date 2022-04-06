// Import the Liquid Crystal library
#include <LiquidCrystal.h>
//Initialise the LCD with the arduino. LiquidCrystal(rs, enable, d4, d5, d6, d7)
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);
int incomingByte;

void setup() {
  // Switch on the LCD screen
  Serial.begin(9600);
  lcd.begin(16, 2);
}

void loop() {
  if (Serial.available() > 0) {
    incomingByte = Serial.read();
    if (incomingByte == 'A') {
      lcd.print("Signed in");
    }
    if (incomingByte == 'B') {
      lcd.print("Signed out");
    }
    if (incomingByte == 'C') {
      lcd.print("Swipe Error");
    }
    if (incomingByte == 'D') {
      lcd.print("Form Empty");
    }
    if (incomingByte == 'E') {
      lcd.clear();
    }
  }
}
