#include <SoftwareSerial.h>
SoftwareSerial RFIDSerial(2, 3);

const int buttonPin = 4;
const int buzzerPin = 5;
const int bellPin = 6;
const int stopPin = 7;
const int forwardPin = 8;
const int rightPin = 9;
const int backwardPin = 10;
const int leftPin =11;

int buttonState;
int lastButtonState = LOW;
long lastDebounceTime = 0;
long debounceDelay = 50;
boolean toyActive = false;

void setup()
{
  RFIDSerial.begin(9600);
  Serial.begin(9600);
  pinMode(buttonPin, INPUT);
  pinMode(buzzerPin, OUTPUT);
  for (int i = 6; i < 12; i++) {
    pinMode(i, OUTPUT);
    digitalWrite(i, HIGH);
  }
}

void loop()
{
  receiveRFIDCardInfo();
  button();
}

void receiveRFIDCardInfo()
{
  static byte data[4];
  static byte temp[14]; 
  byte len;
  static int i = 0;
  unsigned long currentId;
  if(RFIDSerial.available()){
    temp[i++] = RFIDSerial.read();
    if(14 == i){
      if( 0x02 == temp[0] && 0x03 == temp[13]){
        data[0] = Transform(temp[3])*16 + Transform(temp[4]); 
        data[1] = Transform(temp[5])*16 + Transform(temp[6]);
        data[2] = Transform(temp[7])*16 + Transform(temp[8]);
        data[3] = Transform(temp[9])*16 + Transform(temp[10]);
        currentId = (unsigned long)data[0]*16777216 + (unsigned long)data[1]*65536 + (unsigned long)data[2]*256 + (unsigned long)data[3];
        Serial.println(currentId,DEC);
        digitalWrite(buzzerPin, HIGH);
        delay(250);
        digitalWrite(buzzerPin, LOW);
        i = 0;
      }
    }
  }
}

byte Transform(byte dat)
{
  if(dat >= 0x30 && dat <= 0x39) {
    return (dat - 0x30);
  }
  else if(dat >= 0x41 && dat <= 0x46) {
    return (dat - 55);
  }
}

void button() {
  
  // read the state of the pushbutton value:
  int reading = digitalRead(buttonPin);
  
  if (reading != lastButtonState) {
    lastDebounceTime = millis();
  }
  
  if ((millis() - lastDebounceTime) > debounceDelay) {
    buttonState = reading;
  }

  // check if the pushbutton is pressed.
  // if it is, the buttonState is HIGH:
  if (buttonState == HIGH) {
    if (toyActive == false) {
      sendToyControl(forwardPin);
      toyActive = true;
    }
  }
  else {
    if (toyActive == true) {
      sendToyControl(stopPin);
      toyActive = false;
    }
  }
  lastButtonState = reading;
}

void sendToyControl(int pin) {
  digitalWrite(pin, LOW);
  delay(100);
  digitalWrite(pin, HIGH);
}

void serialEvent() {
  if (Serial.available() > 0) {
    char inByte = Serial.read();
    switch(inByte) {
      case 'a': //test
        
        Serial.println("ack");
        break;
      case 'f': //forward
        sendToyControl(forwardPin);
        break;
      case 'r': //right
        sendToyControl(rightPin);
        break;
      case 'b': //backward
        sendToyControl(backwardPin);
        break;
      case 'l': //left
        sendToyControl(leftPin);
        break;
      case 's': //stop
        sendToyControl(stopPin);
        break;
      case 'z': //beep
        digitalWrite(buzzerPin, HIGH);
        delay(500);
        digitalWrite(buzzerPin, LOW);
        break;
      case 'x': //bell sound effect
        sendToyControl(bellPin);
        break;
    }
  }
}
