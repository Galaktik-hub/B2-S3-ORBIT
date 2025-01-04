#include <stdio.h>
#include <assert.h>
#include "graph.h"
#include "heap.h"

#define INF 1e9 // Infini pour les distances

double distance_heuristique(const Graphe* graphe, int sommet_actuel, int objectif) {
    // Vérification des indices valides
    if (sommet_actuel < 0 || sommet_actuel >= graphe->nombre_sommets ||
        objectif < 0 || objectif >= graphe->nombre_sommets) {
        return INF;
    }

    double min_distance = INF;

    // Parcourir les arêtes sortantes du sommet actuel
    for (int i = graphe->sommets[sommet_actuel].debut_in_array;
         i < graphe->sommets[sommet_actuel].debut_in_array + graphe->sommets[sommet_actuel].nombre_aretes; i++) {
        if (graphe->aretes[i].id_planet_arrival == objectif) {
            min_distance = graphe->aretes[i].distance;
            break; // Si une connexion directe est trouvée, on peut arrêter
        }
    }

    // Si aucune connexion directe, fournir une estimation
    if (min_distance == INF) {
        // Retour d'une estimation heuristique, la distance euclidienne
        double dx = graphe->sommets[sommet_actuel].x - graphe->sommets[objectif].x;
        double dy = graphe->sommets[sommet_actuel].y - graphe->sommets[objectif].y;
        min_distance = sqrt(dx * dx + dy * dy);
    }

    return min_distance;
}

// Structure pour un nœud dans l'algorithme A*
typedef struct {
    int sommet;          // Identifiant du sommet
    double cout;         // Coût accumulé
    double heuristique;  // Heuristique totale (cout + distance)
    int parent;          // Parent dans le chemin pour la reconstitution
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
    int current = objectif;

    assert(current != -1);

    printf("Distance:%lf|Chemin:", nodes[current].cout);
    while (current != depart) {
        assert(current != -1);
        printf("%d<-", current);
        current = nodes[current].parent;
    }
    printf("%d\n", depart);
}

// Fonction principale de l'algorithme A*
void astar(Graphe* graphe, int depart, int objectif) {
    if (objectif >= graphe->nombre_sommets || objectif < 0 || depart >= graphe->nombre_sommets || depart < 0) {
        fprintf(stderr, "One of the two IDs does not match any planet: departure %d, arrival %d\n", depart, objectif);
        exit(1);
    }

    TwinHeap openList = newTwinHeap(graphe->nombre_sommets + 1, INF); // Création heap
    int closedList[graphe->nombre_sommets + 1]; // Marqueur des nœuds explorés
    Node nodes[graphe->nombre_sommets + 1];

    for (int i = 0; i <= graphe->nombre_sommets; i++) {
        closedList[i] = 0;  // Initialisation sommets
        nodes[i] = (Node){i, INF, INF, -1};
    }

    // Initialisation point de départ
    nodes[depart].cout = 0;
    nodes[depart].heuristique = distance_heuristique(graphe, depart, objectif);
    nodes[depart].parent = depart;
    editKey(openList, depart, nodes[depart].heuristique);

    while (!emptyHeap(openList)) {
        int u = popMinimum(openList);

        if (nodes[u].parent == -1)  // Sommet non atteignable
            break;

        if (u == objectif) { // Objectif atteint
            reconstituerChemin(nodes, depart, objectif);
            return;
        }

        closedList[u] = 1; // Marquer comme exploré

        // Parcourir tous les voisins de u
        for (int i = graphe->sommets[u].debut_in_array;
             i < graphe->sommets[u].debut_in_array + graphe->sommets[u].nombre_aretes; i++) {
            int v = graphe->aretes[i].id_planet_arrival;
            double poids = graphe->aretes[i].distance;

            if (closedList[v])
                continue; // Ignorer si déjà exploré

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
