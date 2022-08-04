import axios from 'axios';

export default{
  data(){
    return {
      key: '42d098e43e02802fa54c1d21c82376ba',
      baseUrl: 'http://www.kobis.or.kr/kobisopenapi/webservice/rest/',
      boxOfficeByDay: 'boxoffice/searchDailyBoxOfficeList.json',
      boxOfficeByWeek: 'boxoffice/searchWeeklyBoxOfficeList.json',
    }
  },
  methods: {
    async $api(url, parameter) {
        return (await axios.get(url, {
            params: parameter
        })            
        .catch(e => {
            console.log(e);
        })).data;
    },
    async getBoxOfficeByDay(targetDt){
      const parameter = {
        key: this.key,
        targetDt //키값 = 변수명 같을 때 표현방법
      }
      const url = this.baseUrl + this.boxOfficeByDay;
      return await this.$api(url, parameter);
    },
    async getBoxOfficeByWeek(targetDt, weekGb){
      const parameter = {
        key: this.key,
        targetDt,
        weekGb
      }
      const url = this.baseUrl + this.boxOfficeByWeek;
      return await this.$api(url, parameter);
    },
    getOnlyDateStr(date){
      return date.toISOString().split('T')[0];
    }
  }
}