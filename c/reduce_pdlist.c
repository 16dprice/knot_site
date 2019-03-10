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

//#define NELEMS(x)  (sizeof(x) / sizeof((x)[0]))

/* We use a local, compiled in copy of argtable to avoid having to
   depend on system utilities. */

int PD_VERBOSE = 0; // some of the library functions check for this (sets level of error debugging)
int VERBOSE;

void parse_pd_codes();

/**

Three arguments are given to this script. In order, they are the input .txt file name path, the output .txt file path, and
the output .pdstor file path. The input .txt file should begin with a number indicating how many PD codes are in the
file. Then, the PD codes should be provided one right after another separated by a newline character. The output .txt
file will contain the PD codes from the original file that are isotopically different separated by newline characters
but WITHOUT a number at the top indicating how many there are. Look at the .pdstor output for more information on it.
It is a format specific to the library of code that is used here from Jason Cantarella.

*/
void main(int argc, char *argv[]) {

	if(argc < 4) {
	    printf("Not enough arguments supplied.\n");
	    return;
	} else {

		size_t arg_length = strlen(argv[1]);
		char infile_full_path[arg_length];
		strcpy(infile_full_path, argv[1]);

		arg_length = strlen(argv[2]);
		char outfile_full_txt_path[arg_length];
		strcpy(outfile_full_txt_path, argv[2]);

		arg_length = strlen(argv[3]);
		char outfile_full_pdstor_path[arg_length];
		strcpy(outfile_full_pdstor_path, argv[3]);

		parse_pd_codes(infile_full_path, outfile_full_txt_path, outfile_full_pdstor_path);

	}

}

void parse_pd_codes(char infile_full_path[], char outfile_full_txt_path[], char outfile_full_pdstor_path[]) {

	// variable declarations
	FILE *infile, *outfile;
	pd_stor_t *flype_circuit;
	pd_code_t *next_pd_code;
	int i;
	long imax;
	char line[10]; // 10 is big enough, this will just be used to read empty space and a digit from the txt file
	size_t len = 10;
	char *endptr;
	// end variable declarations

//	printf("%s\n", infile_full_path);
//	printf("%s\n", outfile_full_txt_path);
//	printf("%s\n", outfile_full_pdstor_path);

	flype_circuit = pd_new_pdstor();
	infile = fopen(infile_full_path, "r"); // example file

	// iterate through until read is the first line with length not equal to 1
	// this will be the number of pd codes contained in the file
	while(strlen(fgets(line, len, infile)) == 1) {}
	imax = strtol(line, &endptr, 10);

	// run through all of the pd codes and add them to flype_circuit
	// with the restriction of being isotopically different
	printf("Total PD Codes: %ld\n", imax);
	for(i=0; i < imax; i++) {
		// get the next pd code from the file
		next_pd_code = pd_read_KnotTheory(infile);
		// add the pd code to the flype_circuit
		pd_addto_pdstor(flype_circuit, next_pd_code, DIAGRAM_ISOTOPY);
		printf("Done with PD Code %d\n", i + 1);
		// because no garbage collection
		free(next_pd_code);
	}
	printf("DONE READING PD CODES\n");

	// put all the pd codes in a .txt file
	// file path is specified by second input to the script
	outfile = fopen(outfile_full_txt_path, "w");
	for(next_pd_code = pd_stor_firstelt(flype_circuit); next_pd_code != NULL; next_pd_code = pd_stor_nextelt(flype_circuit)) {
		pd_write_KnotTheory(outfile, next_pd_code);
		free(next_pd_code);
	}
	fclose(outfile);

	// write the reduced list of pd codes to a .pdstor file
	// file path is specified by third input to the script
	outfile = fopen(outfile_full_pdstor_path, "w");
	pd_write_pdstor(outfile, flype_circuit);
	fclose(outfile);

	// free everything
	pd_free_pdstor(&flype_circuit);
}