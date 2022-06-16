function sum(n1, n2){
  return n1 + n2;
}

function sum(n1, n2){
  console.log(1111);
}

let ddd = sum;

function sum(n1, n2){
  console.log(2222);
}
console.log(ddd(1, 2));