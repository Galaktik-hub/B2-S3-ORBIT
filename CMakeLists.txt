cmake_minimum_required(VERSION 3.29)
project(SAE_StarWars C)

set(CMAKE_C_STANDARD 11)

add_executable(SAE_StarWars
        c/main.c
        c/graph.c
        c/heap.c
        c/astar.c
)
