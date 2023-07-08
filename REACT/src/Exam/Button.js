import PropTypes from 'prop-types';

export default function Button({color, text, onClick}){ //객체 구조분할
  return (
    <button onClick={onClick} className={color}>{text}</button>
  );
}

Button.propTypes = {
  text: PropTypes.string.isRequired //isRequired 추가 -> 무조건 문자열
}
Button.defaultProps = { //디폴트 들어가면 isRequired는 의미 x
  text: 'btn' 
}