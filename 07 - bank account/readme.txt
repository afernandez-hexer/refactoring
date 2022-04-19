En un sistema de gestión se almacenan las cuentas bancarias de los clientes como un campo de texto sin seguir un formato especifico. 

Necesitamos imprimir en los contractos de los clientes dicha información separando la cuenta en grupos: 
- IBAN (2 letras y 2 números) => iban
- Entidad (4 números) => organization
- Oficina (4 números) => office
- DC (2 números) => controlDigit
- Numero de cuenta (10 números) => accountNumber
- BIC (Swift) (hasta 11 digitos con números y letras) => swift

Como queremos evitar tener que introducir a mano toda esta información vamos a diseñar un sistema que nos permita traducir los datos existentes a un 
formato nuevo que nos de todos estos detalles. 

Ejemplos de posibles cuentas:

ES66 2100 0418 4012 3456 7891
ES66 2100 0418 40 1234567891
ES66.2100.0418.4012.3456.7891
ES66.2100.0418.40.1234567891
ES66 2100 0418 4012 3456 7891 CAIXESBB
ES66 2100 0418 40 1234567891 CAIXESBB
ES66.2100.0418.4012.3456.7891.CAIXESBB
ES66.2100.0418.40.1234567891.CAIXESBB
ES66 2100 0418 4012 3456 7891 CAIXESBBXXX
ES66 2100 0418 40 1234567891 CAIXESBBXXX
ES66.2100.0418.4012.3456.7891.CAIXESBBXXX
ES66.2100.0418.40.1234567891.CAIXESBBXXX
21000418401234567891
2100 0418 40 1234567891
2100.0418.40.1234567891

También pueden incluir espacios extra antes o despues de la cadena.


Dividiremos este problema en apartados para que nos sea más sencillo abordarlo.


A) Validar si el dato existente es suficiente para lo que necesitamos

El primer paso será crear una clase que valide si efectivamente tenemos una cadena de texto válida para obtener los datos que necesitamos.

B) Calculador de IBAN

Suponiendo que tenemos un objeto BankAccount con los datos de organization, office, controlDigit y accountNumber calcular el código iban suponiendo 
que la cuenta es Española.

El algoritmo de calculo de IBAN puede obtenerse aquí: https://www.ennaranja.com/economia-facil/como-calcular-iban/

C) Conversor de cadenas de texto a objetos BankAccount

A partir de las cadenas de ejemplo, debemos construir una objeto BankAccount rellenando todos los datos. Si no proporicionan IBAN debemos calcularlo
asumiendo que están en españa y si no tienen bic, debemos establecerlo a null

D) Validar que una cuenta es válida

A partir de un objeto BankAccount, revisar que efectivamente el código IBAN coincide con el que debería haber y que la longitud de cada campo coincide con
lo que se ha establecido.

E) Sistema final

El sistema final debe proporcionar una clase que implemente la interfaz BankAccountExtractorInterface donde:
- isValidAccount devuelve verdadero si una cadena de texto nos va a permitir generar un BankAccount válido
- extractBankAccount devuelve un objeto BankAccount válido o lanza una excepción indicando el motivo del error a partir de una cadena de texto.