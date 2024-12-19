#include <stdio.h>
#include "graph.h"
#include "heap.h"

#define INF 1e9 // Infini pour les distances

// Fonction heuristique pour A* : retourne 0 pour simuler Dijkstra (aucune heuristique)
// Heuristique basée sur la distance directe minimale entre deux sommets
double distance_heuristique(const Graphe* graphe, int sommet_actuel, int objectif) {
    double min_distance = INF;

    // Parcourir toutes les arêtes pour trouver la distance minimale entre sommet_actuel et objectif
    for (int i = graphe->sommets[sommet_actuel].debut_in_array;
         i < graphe->sommets[sommet_actuel].debut_in_array + graphe->sommets[sommet_actuel].nombre_aretes; i++) {
        if (graphe->aretes[i].id_planet_arrival == objectif) {
            if (graphe->aretes[i].distance < min_distance) {
                min_distance = graphe->aretes[i].distance;
            }
        }
    }
    return min_distance == INF ? 0 : min_distance;
}

// Structure pour un nœud dans l'algorithme A*
typedef struct {
    int sommet;
    double cout;
    double heuristique;
    int parent;
} Node;

// Comparaison des nœuds par leur heuristique (pour la file de priorité)
int compareParHeuristique(const void* a, const void* b) {
    Node* n1 = (Node*)a;
    Node* n2 = (Node*)b;
    if (n1->heuristique < n2->heuristique)
        return 1;
    else if (n1->heuristique == n2->heuristique)
        return 0;
    else
        return -1;
}

// Reconstitution du chemin depuis le sommet de destination
void reconstituerChemin(Node* nodes, int depart, int objectif) {
    printf("Chemin trouvé :\n");
    int current = objectif;
    printf("Distance : %lf\n", nodes[current].cout);
    while (current != depart) {
        printf("%d <- ", current);
        current = nodes[current].parent;
    }
    printf("%d\n", depart);
}

// Fonction principale de l'algorithme A*
void astar(Graphe* graphe, int depart, int objectif) {
    if (objectif > graphe->nombre_sommets || objectif < 1 || depart > graphe->nombre_sommets || depart < 1) {
        fprintf(stderr, "One of the two IDs does not match any planet: departure %d, arrival %d\n", depart, objectif);
        exit(1);
    }

    TwinHeap openList = newTwinHeap(graphe->nombre_sommets + 1, INF);
    int closedList[graphe->nombre_sommets + 1];
    Node nodes[graphe->nombre_sommets + 1];

    for (int i = 0; i <= graphe->nombre_sommets; i++) {
        // Aucun sommet n'est exploré au départ
        closedList[i] = 0;
        nodes[i] = (Node){i, INF, INF, -1};
    }

    // Initialisation du point de départ
    nodes[depart].cout = 0;
    nodes[depart].heuristique = distance_heuristique(graphe, depart, objectif);
    nodes[depart].parent = depart;
    editKey(openList, depart, nodes[depart].heuristique);

    while (!emptyHeap(openList)) {
        // Extraire le sommet avec la plus petite heuristique
        int u = popMinimum(openList);

        if (u == objectif) {
            // Objectif atteint
            reconstituerChemin(nodes, depart, objectif);
            return;
        }

        // Marquer comme exploré
        closedList[u] = 1;

        // Parcourir tous les voisins de u
        for (int i = graphe->sommets[u].debut_in_array;
             i < graphe->sommets[u].debut_in_array + graphe->sommets[u].nombre_aretes; i++) {
            int v = graphe->aretes[i].id_planet_arrival;
            double poids = graphe->aretes[i].distance;

            if (closedList[v])
                continue;

            double nouveauCout = nodes[u].cout + poids;

            // Si un meilleur chemin est trouvé vers v
            if (nouveauCout < nodes[v].cout) {
                nodes[v].cout = nouveauCout;
                nodes[v].heuristique = nouveauCout + distance_heuristique(graphe, v, objectif);
                nodes[v].parent = u;
                editKey(openList, v, nodes[v].heuristique);
            }
        }
    }

    printf("Aucun chemin n'a été trouvé de %d à %d.\n", depart, objectif);
}
