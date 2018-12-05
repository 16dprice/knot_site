#include<stdio.h>
#include<stdbool.h>
#include<string.h>
#include<stdint.h>
#include<stdlib.h>
#include<math.h>
#include<time.h>
#include<assert.h>
#include<limits.h>
#include<inttypes.h>

#include"plcTopology.h"

/* We use a local, compiled in copy of argtable to avoid having to
   depend on system utilities. */

int PD_VERBOSE = 0; // some of the library functions check for this (sets level of error debugging)
int VERBOSE;


void main(int argc, char *argv[]) {

//	printf("Program name %s\n", argv[0]);
	// variables
	pd_stor_t *flype_circuit;
	FILE *infile, *outfile;
	pd_code_t *next_pd_code;
	int i;
	long imax;
	char *line;
	size_t len = 0;
	ssize_t read;
	char *endptr;
	// // char file_name[] = "";

	// if(argc == 2) {
	// 	// strcpy(file_name, argv[1]); // the text file full path
	// 	char file_name[] = argv[1];
	// } else {
	// 	// strcpy(file_name, "/home/dj/knot_research/libplCurve_examples/pdcodes.txt");
	// 	char file_name[] = "/home/dj/knot_research/libplCurve_examples/pdcodes.txt";
	// }

	// printf("%s\n", file_name);

	// some declarations
	flype_circuit = pd_new_pdstor();
	infile = fopen("/var/www/html/knot_site/sandboxes/dj/c/pdcodes.txt", "r"); // example file

	// iterate through until read is the first line with length not equal to 1
	// this will be the number of pd codes contained in the file
	while((read = getline(&line, &len, infile)) == 1) {}

	imax = strtol(line, &endptr, 10);

	printf("imax is %ld\n", imax);

	for(i=0; i < imax; i++) {
		printf("here\n");
		// get the next pd code from the file
		// TODO: what to do if this is null???
		next_pd_code = pd_read_KnotTheory(infile);
        printf("done with pd code %d\n", i + 1);
		// add the pd code to the flype_circuit
		pd_addto_pdstor(flype_circuit, next_pd_code, DIAGRAM_ISOTOPY);

		// because no garbage collection
		free(next_pd_code);
	}

	outfile = fopen("/var/www/html/knot_site/sandboxes/dj/c/reduced_codes.pdstor","w");
	pd_write_pdstor(outfile, flype_circuit);
	fclose(outfile);

	outfile = fopen("/var/www/html/knot_site/sandboxes/dj/c/reduced_codes.txt","w");
	for(next_pd_code = pd_stor_firstelt(flype_circuit); next_pd_code != NULL; next_pd_code = pd_stor_nextelt(flype_circuit)) {

		pd_write_KnotTheory(outfile, next_pd_code);
		free(next_pd_code);
	}

	fclose(outfile);

	// free everything
	pd_free_pdstor(&flype_circuit);

}
