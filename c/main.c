#include "graph.h"
#include "astar.h"

int main() {
    Graphe graphe;

    lire_fichier_et_creer_graphe("../data/serialized_graph.txt", &graphe);
    
    astar(&graphe, 1, 5444);

    //save_graphe_in_file(&graphe, "../data/graph_output.txt");

    liberer_graphe(&graphe);

    return 0;
}
