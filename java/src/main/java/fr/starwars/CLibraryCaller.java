//package fr.starwars;
//
//import java.lang.foreign.*;
//import java.lang.invoke.MethodHandle;
//
//public class CLibraryCaller {
//    public static void main(String[] args) throws Throwable {
//        // Charger la bibliothèque native (remplace 'yourLibrary' par le nom correct)
//        System.loadLibrary("yourLibrary");
//
//        // Déclarer une méthode native (par exemple : 'findShortestPath')
//        Linker linker = Linker.nativeLinker();
//        SymbolLookup stdlib = linker.defaultLookup();
//
//        MethodHandle findShortestPath = linker.downcallHandle(
//                stdlib.lookup("findShortestPath").orElseThrow(),
//                FunctionDescriptor.ofVoid(
//                        ValueLayout.ADDRESS, // Chemin d'entrée (graphe)
//                        ValueLayout.ADDRESS  // Chemin de sortie (résultat)
//                )
//        );
//
//        // Convertir les chaînes en pointeurs natifs
//        MemorySegment inputFile = SegmentAllocator.nativeAllocator().allocateUtf8String("graphe.txt");
//        MemorySegment outputFile = SegmentAllocator.nativeAllocator().allocateUtf8String("result.txt");
//
//        // Appeler la fonction native
//        findShortestPath.invoke(inputFile, outputFile);
//
//        System.out.println("Itinéraire calculé avec succès !");
//    }
//}
