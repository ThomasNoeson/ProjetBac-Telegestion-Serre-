int led= 0; // La LED est câblé sur la broche N°3 de la carte Arduino
boolean print =false;

void setup() {
  Serial.begin(9600);
  pinMode(3,OUTPUT);

}

void loop() {
  led= analogRead(0);
  
  Serial.print("La Valeur du capteur est de : ");
  Serial.print(led);
  Serial.print(" lux");
  Serial.println();

  if (( (led) > (350) && !print)) {
    digitalWrite(3,LOW);
    Serial.println("La lampe est donc eteinte");
    Serial.println("");
    print=true;
  }
  
    else {
  if (( (led) < (350) && print)) {
      digitalWrite(3, HIGH);
      Serial.println("La lampe est donc allume");
      Serial.println("");
      print = false;
    }
  }
  delay(750);
}
