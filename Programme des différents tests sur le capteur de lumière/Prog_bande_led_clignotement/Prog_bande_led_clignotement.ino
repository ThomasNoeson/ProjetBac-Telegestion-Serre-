int LED= 3;  
int temt6000Pin = 0;

void setup() {
  Serial.begin(9600);       
  pinMode(LED, OUTPUT);
}

void loop() {
  int value = analogRead(temt6000Pin);
  Serial.print("La valeur du capteur est : ");
  Serial.print(value);
  Serial.println(" lux");
  digitalWrite(LED, HIGH);
  delay(200);
  digitalWrite(LED, LOW);
  delay(1000);
}
