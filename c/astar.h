#ifndef ASTAR_H
#define ASTAR_H

#include <stdio.h>
#include <stdlib.h>
#include "graph.h"
#include "heap.h"

#define INF 1e9 // Infini pour les distances

// Fonction heuristique pour A* : retourne 0 pour simuler Dijkstra (aucune heuristique)
// Heuristique basée sur la distance directe minimale entre deux sommets
double distance_heuristique(const Graphe* graphe, int sommet_actuel, int objectif);

// Structure pour un nœud dans l'algorithme A*
typedef struct {
    int sommet;          // Identifiant du sommet
    double cout;         // Coût accumulé
    double heuristique;  // Heuristique totale (cout + distance)
    int parent;          // Parent dans le chemin pour la reconstitution
} Node;

// Comparaison des nœuds par leur heuristique (pour la file de priorité)
int compareParHeuristique(const void* a, const void* b);

// Reconstitution du chemin depuis le sommet de destination
void reconstituerChemin(Node* nodes, int depart, int objectif);

// Fonction principale de l'algorithme A*
void astar(Graphe* graphe, int depart, int objectif);

#endif