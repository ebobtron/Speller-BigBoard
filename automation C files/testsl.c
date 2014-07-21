/******
 *
 *  testsl.c 
 *  ebobtron, Robert Clark
 *  
 *   CS50x  winter 2014 with launchcode
 *  
 *  compile performance data for pset6 speller.c
 *  the version test special linux conforms to 
 *  the file structure of the linux mint installation on
 *  my HP Porbook 4440s laptop
 *
 ******/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <glob.h>



int main(int argc, char* argv[])
{
    if (argc < 4 || argc > 6)
    {
       printf("Usage: ./test ./speller id submission_name [memory]\n");
       return 1;
    }
    
    
    double totalloadtime = 0;
    double totalchecktime = 0;
    double totalsizetime = 0;
    double totalunloadtime = 0;
    double totaltime = 0;    

    double vals[8];
    char linebuf[30];

    char* path = "/home/cs50/pset6/texts/";
    short int pathSize = strlen(path);
    
    glob_t data;
    glob_t data2;
     
    switch(glob("/home/cs50/pset6/texts/*.txt", 0, NULL, &data ))
    {
        case 0:
            break;
        case GLOB_NOSPACE:
            printf( "Out of memory\n" );
            break;
        case GLOB_ABORTED:
            printf( "Reading error\n" );
            break;
        case GLOB_NOMATCH:
            printf( "No files found\n" );
            break;
        default:
            break;
    }
    
    switch(glob("/home/robclark/Dropbox/autosbb/results", 0, NULL, &data2 ))
    {
        case 0:
            break;
        case GLOB_NOSPACE:
            printf( "Out of memory\n" );
            break;
        case GLOB_ABORTED:
            printf( "Reading error\n" );
            break;
        case GLOB_NOMATCH:
            printf( "directory results not found\n" );
            printf( "making results \n" );
            system("mkdir results");
            break;
        default:
            break;
    }
    
    char com[200];
    char fname[100];
    
    //                     data.gl_pathc
    for(int i = 0; i < data.gl_pathc; i++)
    {
        short int fcount = 0;
        for(int j = pathSize; j < strlen(data.gl_pathv[i]); j++)
        {
           fname[fcount] = data.gl_pathv[i][j];
           fname[fcount+1] ='\0';
           fcount++;
        }  
        
        //printf( "%s  %s\n", data.gl_pathv[i] , fname );
        sprintf(com, "%s %s > results/%s", argv[1], data.gl_pathv[i], fname);
        system(com);
    }
    
      // prepare a data holder u may call it a file
    FILE* outfile = fopen("submis.txt","a+");

    // collect the data   
    int ntest = 0;
    for(int i = 0; i < data.gl_pathc; i++)
    {  
        short int fcount = 0;
        for(int j = pathSize; j < strlen(data.gl_pathv[i]); j++)
        {
           fname[fcount] = data.gl_pathv[i][j];
           fname[fcount+1] ='\0';
           fcount++;
        }
        sprintf(com, "results/%s", fname);
        FILE* infile = fopen(com, "r");
        if (infile)
        {
            fseek(infile,-150, SEEK_END);
            
            fgets(linebuf, sizeof(linebuf),infile);
            for(int j =  0; j < 6; j++)
            {
                fgets(linebuf, sizeof(linebuf),infile);
                int k = 20;
                int k2 = 0;
                while(linebuf[k] != '\n')
                {
                    com[k2] = linebuf[k];
                    k++;
                    k2++;
                }
                com[k2] = '\0';
                vals[j] = atof(com);
            } 
        }

    
        if (infile)
        {
            fclose(infile);
        }
        
        
        totalloadtime = totalloadtime + vals[0];
        totalchecktime = totalchecktime + vals[1];
        totalsizetime = totalsizetime + vals[2];
        totalunloadtime = totalunloadtime + vals[3];
        totaltime = totaltime + vals[4];
        
        if (argc == 6)
        { 
            sprintf(com, "%s,%1.4f,%1.4f,%1.4f,%1.4f,%1.4f\n", \
                           fname, vals[4], vals[0], vals[1], vals[2], vals[3]);
            printf("%s", com);
        }
        ntest++;
        
    } 
    sprintf(com, "%s,%s,%1.4f,%1.4f,%1.4f,%1.4f,%1.4f,%s\r\n", \
     argv[2], argv[3], totaltime/ntest, totalloadtime/ntest, totalchecktime/ntest, \
      totalsizetime/ntest, totalunloadtime/ntest, argv[4]);
    
    fwrite(com, strlen(com), 1, outfile);
    fclose(outfile);
    
    printf("%s", com);
    
    globfree(&data);
    return 0;
}
