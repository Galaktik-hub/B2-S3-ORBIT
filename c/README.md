# Partie C

## Compilation

Pour compiler le module C, vous devez vous rendre dans le dossier `c` et exécuter la commande suivante :

```bash
gcc -Wall -o main main.c graph.c heap.c astar.c
```

## Explication du `main.c` :

Le code principal reste relativement simple. Il se décompose en plusieurs segments :

- Initialisation des variables et des structures de données.
- Lecture du fichier d'entrée et construction du graphe.
- Éxécution de l'algo A* sur le graphe.
- Libération des ressources et fin du programme.
