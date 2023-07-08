var n1; //호이스팅 o
var nn2 = 20;
n1 = 30;
var nn3 = n1 + nn2;

console.log('nn3 : ' + nn3);
console.log("10" + 10);
console.log("10" - 10);
console.log("10" * 10);
console.log(10 + 10 + '10');
console.log(10 + 10 * '10');
console.log('10' + 10 + 10);

let n2; //호이스팅 x
n2 = 10;
const N3 = 10; //호이스팅 x
