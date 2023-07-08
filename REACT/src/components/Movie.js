export default function Movie(data){
  // const movie = props.data;
  const {title, medium_cover_image, summary, genres} = data.movie;
  return (
    <div>
    <h2><a href="">{title}</a></h2>
    <img src={medium_cover_image} alt={title} />
    <p>{summary}</p>
    <ul>
      {
        genres.map((item, idx) =>
          (<li key={idx}>{item}</li>)
        )
      }
    </ul>
    </div>
  );
}