//객체 생성, 다른 객체언어 => function 아니고 Class
function Human(name, age){
  // 1)속성
  this.name = name;
  this.age = age;

  // 2)메소드(function)
  this.showMe = function(){
    console.log(`My name is ${this.name}, age is ${this.age}.`);
  }
}

var h1 = new Human('홍길동', 20);
//갑자기 객체에 메소드 추가 가능(js만)
Human.prototype.hello = function(){
  console.log(`Hello ${this.name}`);
}
h1.height = 180;
var h2 = new Human('둘리', 120);

h1.showMe();
h2.showMe();

h1.hello();
h2.hello();

console.log("h1.height : " + h1.height);
console.log("h2.height : " + h2.height);