#include<stdio.h>
#include<stdlib.h>
#include<string.h>

void main(int argc, char *argv[]) {

    printf("Hello, World!\n");

    if(argc == 2) {
        char path[100]; // there's no way the path will be over 100 characters... I really hope
        strcpy(path, argv[1]);

        printf("%s\n", path);

        char full_path[150];
        strcpy(full_path, strcat(path, "/test.txt"));

        fopen(full_path, "r");

    } else {
        return;
    }

}