// 혼자 해본 거
// const btnFollow = document.querySelector('#btnFollow');
// if(btnFollow){
//     btnFollow.addEventListener('click', function(){
//         let followNum = parseInt(this.dataset.follow);
//         const method = followNum === 0 ? 'POST' : 'DELETE';
//         fetch(`/user/follow?iuser=${this.dataset.iuser}`, {
//             'method': method
//         }).then(res => res.json())
//         .then(res => {
//             if(res.result){
//                 followNum = 1 - followNum;
//                 if(followNum === 1){
//                     this.className = 'btn btn-outline-secondary';
//                     this.dataset.follow = "1";
//                     this.innerText = '팔로우 취소';
//                 }else{
//                     this.className = 'btn btn-primary';
//                     this.dataset.follow = "0";
//                     if(this.dataset.youme === "1"){
//                         this.innerText = '맞팔로우 하기';
//                     }else{
//                         this.innerText = '팔로우';
//                     }
//                 }
//             }
//         })
//     });
// }

function getFeedList() {
    const feedIuser = lData.dataset.toiuser;
    // const url = new URL(location.href); url로 iuser 값 가져오기
    // const feedIuser = url.searchParams.get('iuser');
    if(!feedObj) { return; }
    feedObj.showLoading();            
    const param = {
        page: feedObj.currentPage++,
        feedIuser: feedIuser
    }
    fetch('/user/feed' + encodeQueryString(param))
    .then(res => res.json())
    .then(list => {                
        feedObj.makeFeedList(list);                
    })
    .catch(e => {
        console.error(e);
        feedObj.hideLoading();
    });
}
getFeedList();

(function(){
    const lData = document.querySelector('#lData');
    const spanFollower = document.querySelector('#spanFollower');
    let follower = parseInt(spanFollower.innerText);
    const btnFollow = document.querySelector('#btnFollow');
    if(btnFollow){
        btnFollow.addEventListener('click', function(){
            const param = {
                toiuser: parseInt(lData.dataset.toiuser)
            };
            console.log(param);
            const follow = btnFollow.dataset.follow;
            console.log(`follow: ${follow}`);
            const followUrl = '/user/follow';
            switch(follow){
                case '1': //팔로우 취소
                    fetch(followUrl + encodeQueryString(param), {method: 'DELETE'})
                    .then(res => res.json())
                    .then(res => {
                        if(res.result){
                            btnFollow.dataset.follow = '0';
                            btnFollow.className = 'btn btn-primary';
                            if(btnFollow.dataset.youme === '1'){
                            btnFollow.innerText = '맞팔로우 하기';
                            }else{
                                btnFollow.innerText = '팔로우';
                            }
                            follower = follower - 1;
                            spanFollower.innerText = follower;
                        }
                    });
                    break;
                case '0': //팔로우 등록
                    fetch(followUrl, {method: 'POST', body: JSON.stringify(param)})
                    .then(res => res.json())
                    .then(res => {
                        if(res.result){
                            btnFollow.dataset.follow = '1';
                            btnFollow.className = 'btn btn-outline-secondary';
                            btnFollow.innerText = '팔로우 취소';
                        }
                        follower = follower + 1;
                        spanFollower.innerText = follower;
                    });
                    break;
            }
        })
    }
})();