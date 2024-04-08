// $(function(){
//     console.log('読み込みました');
// })


// function deleteEvent(){

//     $('#delete-btn').on(click , function(e){

//         e.preventDefault(); // デフォルトの動作を止める
//         let deleteConfirm = confirm('削除しますか？');

//         if(deleteConfirm == true){
//             let clickEle = $(this);
//             // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
//             let deleteId = clickEle.data('#delete-id');
//             console.log(deleteId);

//             $.ajaxSetup({
//                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
//             });

//             $.ajax({
//                 // 送信設定～～～～～
//                 url:'/index',
//                 type:'POST',
//                 data:{'_method':'DELETE'}

//             }).done(function(data){
//                 // 実行の内容～～～～～
//                 console.log('削除出来ました。');
//                 // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
//                 clickEle.parents('tr').remove();

//                 // $('#pr-table').trigger("update");

//             }).fail(function(){
//                 // 失敗の内容～～～～～
//                 alert('削除失敗')
//             });
//         }else{
//             e.preventDefault();   
//         }
//     });
// };