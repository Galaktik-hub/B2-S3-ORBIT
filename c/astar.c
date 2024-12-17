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
    return min_distance == INF ? 0 : min_distance; // Si aucune arête directe, renvoie 0
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
    printf("Chemin trouvé :\n");
    int current = objectif;
    int sum;
    while (current != depart) {
        printf("%d <- ", current);
        current = nodes[current].parent;
    }
    printf("%d\n", depart);
    printf("Distance : %d", )
}

// Fonction principale de l'algorithme A*
void astar(Graphe* graphe, int depart, int objectif) {
    TwinHeap openList = newTwinHeap(graphe->nombre_sommets + 1, INF); // Créer un tas de priorité
    int closedList[graphe->nombre_sommets + 1]; // Marqueur des nœuds explorés
    Node nodes[graphe->nombre_sommets + 1];     // Informations sur chaque sommet

    for (int i = 0; i <= graphe->nombre_sommets; i++) {
        closedList[i] = 0; // Aucun sommet n'est exploré au départ
        nodes[i] = (Node){i, INF, INF, -1};
    }

    // Initialisation du point de départ
    nodes[depart].cout = 0;
    nodes[depart].heuristique = distance_heuristique(graphe, depart, objectif);
    nodes[depart].parent = depart;
    editKey(openList, depart, nodes[depart].heuristique);

    while (!emptyHeap(openList)) {
        int u = popMinimum(openList); // Extraire le sommet avec la plus petite heuristique

        if (u == objectif) { // Objectif atteint
            reconstituerChemin(nodes, depart, objectif);
            return;
        }

        closedList[u] = 1; // Marquer comme exploré

        // Parcourir tous les voisins de u
        for (int i = graphe->sommets[u].debut_in_array;
             i < graphe->sommets[u].debut_in_array + graphe->sommets[u].nombre_aretes; i++) {
            int v = graphe->aretes[i].id_planet_arrival;
            double poids = graphe->aretes[i].distance; // Utilisation correcte de la distance depuis Arete

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

void test1_simple() {
    Graphe graphe;
    initialiser_graphe(&graphe, 4, 4);

    graphe.sommets[0] = (Sommet){0, 0, 1};
    graphe.sommets[1] = (Sommet){1, 1, 1};
    graphe.sommets[2] = (Sommet){2, 2, 1};
    graphe.sommets[3] = (Sommet){3, 3, 1};

    graphe.aretes[0] = (Arete){0, 1.0, 1};
    graphe.aretes[1] = (Arete){1, 1.0, 2};
    graphe.aretes[2] = (Arete){2, 1.0, 3};
    graphe.aretes[3] = (Arete){0, 2.5, 3};

    printf("### Test 1 : Graphe simple ###\n");
    astar(&graphe, 0, 3);
    liberer_graphe(&graphe);
}

void test2_moderement_complexe() {
    Graphe graphe2;
    initialiser_graphe(&graphe2, 6, 8);

    graphe2.sommets[0] = (Sommet){0, 0, 2};
    graphe2.sommets[1] = (Sommet){1, 2, 2};
    graphe2.sommets[2] = (Sommet){2, 4, 1};
    graphe2.sommets[3] = (Sommet){3, 5, 1};
    graphe2.sommets[4] = (Sommet){4, 6, 1};
    graphe2.sommets[5] = (Sommet){5, 7, 1};

    graphe2.aretes[0] = (Arete){0, 1.0, 1};
    graphe2.aretes[1] = (Arete){0, 2.0, 2};
    graphe2.aretes[2] = (Arete){1, 2.5, 3};
    graphe2.aretes[3] = (Arete){1, 1.5, 4};
    graphe2.aretes[4] = (Arete){2, 2.0, 3};
    graphe2.aretes[5] = (Arete){3, 1.0, 5};
    graphe2.aretes[6] = (Arete){4, 2.5, 5};
    graphe2.aretes[7] = (Arete){5, 0, 5};

    printf("### Test 2 : Graphe modérément complexe ###\n");
    astar(&graphe2, 0, 5);
    liberer_graphe(&graphe2);
}

void test3_dense() {
    Graphe graphe;
    initialiser_graphe(&graphe, 8, 16);

    graphe.sommets[0] = (Sommet){0, 0, 3};
    graphe.sommets[1] = (Sommet){1, 3, 3};
    graphe.sommets[2] = (Sommet){2, 6, 3};
    graphe.sommets[3] = (Sommet){3, 8, 2};
    graphe.sommets[4] = (Sommet){4, 10, 2};
    graphe.sommets[5] = (Sommet){5, 12, 2};
    graphe.sommets[6] = (Sommet){6, 14, 1};
    graphe.sommets[7] = (Sommet){7, 15, 0};

    graphe.aretes[0]  = (Arete){0, 1.5, 1};
    graphe.aretes[1]  = (Arete){0, 2.0, 2};
    graphe.aretes[2]  = (Arete){0, 2.5, 4};
    graphe.aretes[3]  = (Arete){1, 1.0, 3};
    graphe.aretes[4]  = (Arete){1, 2.5, 4};
    graphe.aretes[5]  = (Arete){1, 2.0, 5};
    graphe.aretes[6]  = (Arete){2, 2.0, 4};
    graphe.aretes[7]  = (Arete){2, 1.5, 5};
    graphe.aretes[8]  = (Arete){2, 3.0, 6};
    graphe.aretes[9]  = (Arete){3, 1.0, 6};
    graphe.aretes[10] = (Arete){3, 2.0, 7};
    graphe.aretes[11] = (Arete){4, 1.5, 6};
    graphe.aretes[12] = (Arete){4, 2.5, 7};
    graphe.aretes[13] = (Arete){5, 1.0, 6};
    graphe.aretes[14] = (Arete){5, 1.5, 7};
    graphe.aretes[15] = (Arete){6, 1.0, 7};

    printf("### Test 3 : Graphe dense ###\n");
    astar(&graphe, 0, 7);
    liberer_graphe(&graphe);
}

void test4_lineaire_long() {
    Graphe graphe;
    initialiser_graphe(&graphe, 10, 9);

    for (int i = 0; i < 10; i++) {
        graphe.sommets[i] = (Sommet){i, i * 2, 0};
        if (i < 9) {
            graphe.aretes[i] = (Arete){i, 1.0, i + 1}; // Connexion linéaire
        }
    }

    printf("### Test 4 : Graphe linéaire long ###\n");
    astar(&graphe, 0, 9);
    liberer_graphe(&graphe);
}

int main_test() {
    printf("==== Début des tests A* ====\n\n");

    test1_simple();
    printf("\n-----------------------------\n\n");

    // test2_moderement_complexe();
    printf("\n-----------------------------\n\n");

    test3_dense();
    printf("\n-----------------------------\n\n");

    test4_lineaire_long();
    printf("\n-----------------------------\n\n");

    printf("==== Fin des tests A* ====\n");
    return 0;
}
