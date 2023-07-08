import { useState } from 'react'; //{} -> 부분(속성)만 받겠다

function Exam2() {
  const [counter, setCounter] = useState(10); //배열 구조분할

  function countUp() {
    /*
    counter = counter + 1;
    console.log(counter);
    */
    //  setCounter(counter + 1);
    setCounter(preVal => preVal + 1); // 콜백함수 -> 직접 값 바꾸는 것보다 안정적
  }

  return (
    //부모는 무조건 1개
    <div>
      <h1>클릭 카운터 수 : {counter}</h1>
      <button onClick={countUp}>Click Me</button>
    </div>
  );
}

export default Exam2;