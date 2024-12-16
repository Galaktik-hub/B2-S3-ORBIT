#include <stdio.h>
#include "graph.h"

int main() {
    Graphe graphe;

    lire_fichier_et_creer_graphe("../data/serialized_graph.txt", &graphe);

    // appel astar
    // struct plus court chemin

    save_graphe_in_file(&graphe, "../data/graph_output.txt");

    liberer_graphe(&graphe);

    // printf(sortie_plus_court_chemin);

    return 0;
}
