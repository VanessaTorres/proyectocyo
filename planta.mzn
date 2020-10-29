%parametros
enum plantas;
array[plantas] of float: produccionesDiarias;
array[plantas] of float: costos;

enum dias;
enum clientes;
array[clientes, dias] of float: demanda; 

int: n = length(dias);

%Variables

array[dias] of var float: uso; %arreglo con la demanda diaria
array[dias,plantas] of var float: resultado;  % relacion demanda diaria con las  plantas de energia

%restricciones

%calcula cantidad de energia requerida por dia 
constraint forall (d in dias) (     
      uso[d] = sum (c in clientes)(demanda[c, d]) 
);


%produccion por dia no debe pasar la producion maxima
constraint forall (d in dias) (     
      uso[d] <= sum(p in plantas)(produccionesDiarias[p]) 
);


% no negatividad
constraint forall(i in dias)(
    forall(p in plantas)( resultado[i,p] >=0)
);


%limita las variables a la produccion diaria 
constraint forall(i in dias)(
    forall(p in plantas)( resultado[i,p] <= produccionesDiarias[p])
);

%la suma de lo que producen las plantas en un dia debe ser igual a la demanda en ese dia
constraint forall(i in dias)(
    sum(p in plantas)( resultado[i,p]  ) = uso[i]
);


%funcion objetivo
var float: z =  sum (i in dias )( sum( p in plantas)(resultado[i,p]  * costos[p] )  ) ;
solve minimize z;

output ["\n\(dias[i])  | \(plantas[p]) | =  \(resultado[i,p])" | i in dias,p in plantas];



