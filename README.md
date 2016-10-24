# Klanten Fiche
Klanten OverZicht met Details en BootCards

## RoadMap
+ OverZicht klanten
+ OverZicht Producten per klanten
+ OverZicht Details per product
+ Toevoegen Klanten
+ Toevoegen Details per product
+ Toevoegen Producten per klant
+ Klant verwijderen doet alles weg van klant
+ Product verwijderen doet alles weg van Details voor product
+ HTTPS standaard ( htacces )
+ Zoeken op Achternaam voornaam - Adress - Telefoon - gemeente of klantnummer ( id )
+ Auto select eerst gevonden klant

## Inhoud
+ Alles van Base Systeem
+ Voeg Klanten toe
+ Zoek Klanten
+ Ajax Gebaseerd

execute de SQL script en je kan beginnen 

gebruiker : admin 
wachtwoord : 123456

#Database opbouw

## gebruikers
| id |   naam 	 | wachtwoord | rechten |groep|
|----|-----------|------------|---------|-----|
| 1	 |	 Admin	 | 	  SHA1	  |    3  	|  1  |
| 15 | 	 User	 |    SHA1	  |	   1  	|     |
### info
- 1 = gebruiker
- 2 = staff
- 3 = admin

## groep
| id | user  |    naam 	 |
|----|-------|-----------|
| 1  |  1,15 | TestGroep |

## details
| id |	pid	|	naam	|	info	|  lid	|
|----|------|-----------|-----------|-------|
| 1	 |	2	|	Test	|	info	|	1	|

## producten
| id |	naam	|	info	|	klant	|
|----|----------|-----------|-----------|
| 2	 |	Test	|	info	|	  3  	|

## klanten
| id |	naam	|	straat	|	nummer	|	 postcode	|	 gemeente	|	stad	|	 land	|	telefoon	|	email	|
|----|----------|-----------|-----------|---------------|---------------|-----------|-----------|---------------|-----------|
| 3	 |	Te St	|  Somwhere	|	  15  	|	   ABC23	|	 Unknown	|	Earth	|	 Mars  	|	12345678	|	ea@rth	|