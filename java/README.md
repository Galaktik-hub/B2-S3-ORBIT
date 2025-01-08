# Partie JAVA

## Initialisation

Pour pouvoir correctement lancer le programme, vous devez créer le fichier `src/main/java/fr/starwars/DatabaseConfig.java`.

```java
package fr.starwars;

public class DatabaseConfig {
    public static final String URL = "jdbc:mysql://localhost:3306/[nom_base_données]"; // Le nom de votre base de données, vous pouvez aussi remplacer localhost par l'url d'un serveur MySQL externe
    public static final String USER = "root";   // Votre nom d'utilisateur
    public static final String PASSWORD = "";   // Le mot de passe utilisateur, si besoin
}
```

Ensuite, vous pouvez initialiser le projet avec Maven :

```bash
mvn clean install
```

## Explication du `CExecutor.java` :

Dans le fichier `src/main/java/fr/starwars/CExecutor.java`, vous trouverez une méthode main, le point d'entrée de notre programme Java.

Cette méthode principale tout d'abord créer un objet de type `File` selon la légion choisie, pour pouvoir sérialiser le graphe.
Ensuite, le programme fait appel à la méthode getGraphFromDatabase() de la classe `GraphProvider`.
Le programme va ensuite utiliser `ProcessBuilder` pour éxécuter le module C et obtenir le plus court chemin, selon les arguments passés par l'utilisateur.
Pour finir, le programme envoie sur la sortie standard le retour de l'éxécutable C, puis supprime le fichier du graphe sérialisé.