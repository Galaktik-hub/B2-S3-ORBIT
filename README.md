# 🌌 O.R.B.I.T (Optimal Route Booking Intergalactic Travel)

## 📚 Contexte du Projet

🎓 Ce projet s’inscrit dans l’univers Star Wars et dans le cadre de la SAÉ Développement d'une application. L’objectif est d’aider les utilisateurs à optimiser leurs déplacements interplanétaires selon divers critères tels que la légion d'appartenance (Rebelle, Empire, Neutre), le nombre de passagers ou encore les vaisseaux préférés.

Le projet repose sur la modélisation de réseaux galactiques et inclut des fonctionnalités immersives qui respectent l’esthétique et les codes de l’univers Star Wars.

---

## 🚀 Objectifs

### 🎯 Objectif Principal

Permettre aux utilisateurs de trouver le meilleur itinéraire entre deux points galactiques en tenant compte de divers critères.

### ⭐ Objectifs Secondaires

- Proposer une interface utilisateur intuitive et immersive.
- Optimiser la gestion des données pour des recherches rapides et précises.
- Offrir une modularité permettant d’ajouter des fonctionnalités ultérieures (ex : profils personnalisés, gestion des vaisseaux).

---

## 🌐 Projet final

Vous pouvez retrouver le projet final hébergé à l'adresse ci-dessous :

🔗 [https://orbit.julien-synaeve.fr](https://orbit.julien-synaeve.fr)

💻 Il vous suffit de vous inscrire pour accèder au site.

---

## 🔧 Fonctionnalités

### 🎨 Front-End

**Fonctionnalités principales**

- **Page principale** :
  - 🌍 Sélection des planètes de départ et d’arrivée.
  - ⚙️ Choix des contraintes (Légion, Vaisseaux, Passagers).
  - 🛰️ Affichage du meilleur itinéraire possible avec des détails (temps, coût, étapes).

- **Visualisation graphique** :
  - 🗺️ Carte interactive des connexions entre planètes et astroports.
  - 🎥 Animations des trajets.

- **Gestion des utilisateurs** :
  - 👤 Création de profils (avatar, pseudo).
  - 🕑 Accès à l’historique des commandes.

- **Système d’administration** :
  - 🛠️ Mise à jour des routes et des planètes.
  - 🚧 Ajout de nouvelles contraintes ou restrictions (ex : blocus impérial).

### 💻 Back-End (PHP, Java)

**Fonctionnalités principales**

- **Modélisation des graphes** :
  - 🔗 Création d'un réseau global sous forme de graphes avec gestion de grandes quantités de données.

- **Gestion des données** :
  - 📂 Interaction avec une base de données relationnelle.
  - 🗃️ Fourniture des données nécessaires pour les calculs et l’affichage.

- **API REST** :
  - 🔄 Permettre l’échange de données entre le PHP, le Java et le module C.

**Contraintes techniques**

- ⚡ Gestion efficace de graphes pouvant inclure des centaines de milliers de nœuds et d’arêtes.
- 🛠️ Implémentation modulaire et maintenable.

### ⚙️ Module C

**Fonctionnalités principales**

- **Calculs optimaux** :
  - 📍 Algorithme de Dijkstra pour le plus court chemin.
  - 🧠 Variante A* pour une optimisation basée sur une heuristique euclidienne.

- **Prise en compte des contraintes** :
  - 🛡️ Meilleur itinéraire en fonction de la légion d'appartenance.

**Contraintes techniques**

- 📡 Échange de données entre Java et l'algorithme C.
- ⏱️ Hautes performances pour des calculs en temps réel.

---

## 🛠️ Technologies Utilisées

Les technologies et outils utilisés incluent :
- **Back-end** : PHP, Java, C, MySQL.
- **Front-end** : HTML/CSS & JS.
- **Bases de données** : MySQL.
- **Modules & Bibliothèques** : PHPMailer.

---

## 🧑‍💻 Développement à Partir du Code Source

### 1️⃣ **Prérequis**
- Serveur PHP.
- Serveur MySQL.
- 📧 Adresse mail avec possibilité d'envoyer des mails depuis PHPMailer.

### 2️⃣ **Installation**
- Clonez ce dépôt : 
```bash
git clone https://github.com/AbdelRMB/sae-starwars.git
```
- 📦 Importez la base de données MySQL à l'aide du fichier `data/orbit.sql`.
- Dans votre IDE Java, faites un clic droit sur le fichier `java/pom.xml` puis `Utiliser le projet Maven`, ou lancer en console la commande :

```bash
mvn clean install
```


### 3️⃣ **Fichiers de configuration** :

📄 Vous devez créer plusieurs fichiers de configuration pour établir les différentes connexions nécessaires. À chaque fois, il existe un fichier s'appelant [nom_fichier]-copie.[extension] qui est une copie vide de ce que vous devez créer.
    
- Fichier `java/src/main/java/fr/starwars/DatabaseConfig.java`
```java
package fr.starwars;

public class DatabaseConfig {
    public static final String URL = "jdbc:mysql://localhost:3306/[nom_base_données]"; // Le nom de votre base de données, vous pouvez aussi remplacer localhost par l'url d'un serveur MySQL externe
    public static final String USER = "root";   // Votre nom d'utilisateur
    public static final String PASSWORD = "";   // Le mot de passe utilisateur, si besoin
}
```

- Fichier `back/cnx.php`
```php
<?php
$host = '';             // Le nom de votre serveur de base de données, localhost ou URL externe
$dbname = '';           // Le nom de votre base de données
$username = '';         // Le nom d'utilisateur utilisé sur la base de données
$password = '';         // Le mot de passe utilisateur
$mail = '';             // Le nom de l'email
$password_mail = '';    // Le code secret utilisé pour se connecter au mail

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
```

### 4️⃣ **Installation de PHPMailer** :
- Décompressez l'archive `data/lib.zip` à la racine du projet

### 5️⃣ **Démarrage** :
   - Lancez les serveurs (PHP & MySQL).
   - 🎉 Vous êtes prêts !

## 🙌 Crédit

Ce projet a été réalisé par une équipe d'étudiants en informatique :
- [RICHE Abdelrahim](https://www.linkedin.com/in/abdelrahim-riche-504a88256/)
- [SYNAEVE Julien](https://www.linkedin.com/in/julien-synaeve)
- [TELLE Alexis](https://www.linkedin.com/in/alexis-telle)
