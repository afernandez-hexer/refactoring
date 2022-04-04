Necesitamos un programa que se ejecutará el último día del mes y calculará para cada usuario del sistema la nomína en función de las horas trabajadas cada día de dicho mes. 

Obtendremos las horas a través de una API externa. La clase Clickup/Timer.php usa dicha API y nos devuelve un array con las intervalos de tiempo registrados por los diferentes usuarios del sistema
identificados por su email. Puede verse un ejemplo, de los datos que devuelve en dicha clase. Debemos calcular las horas totales registradas sumando los periodos obtenidos y redondeando al entero 
más próximo.

Calcularemos el salario teniendo en cuenta que si no superan las horas diarias de cada trabajador (hoursPerDay), ese trabajador cobrará su salario mensual (monthlySalary). 

Si las supera, deberá añadir a ese salario las horas trabajadas adicionales multiplicado por el coste de hora extra de dicho trabajador (overtimeSalaryPerHour). 

Una vez calculados se guardaran en objetos Salary mediante el método de SalaryRepository llamado "save".

Podemos obtener los usuarios con el método de UserRepository llamado "findWorkers" o buscandolos por email mediante "findWorkerByEmail".

NOTA 1: Toda clase no existente en el sistema actual debe tener su test unitario correspondiente.
NOTA 2: No es necesario implementar para el sistema real las clases de los repositorios: SalaryRepository o UserRepository.