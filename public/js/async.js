
// 検索の方
// $(function(){
//     console.log('読み込みOK');
//     deleteEvent();

//     $('#search-btn').on(click , function(e){
//         console.log('検索を押す');
//         e.preventDefault();

//         let formData = $('#serch-form').serialize();
//     })

//     $.ajax({
//         url:'/index',
//         type:'GET',
//         data:'formDate',
//         datatype:'html'
//     }).done(function(data){
//         console.log('成功');
//         let newTarble = $(data).find('#products-table');
//         $('#products-table').replaceWith(newTable);
//         loadSort();
//         deleteEvent();
//     }).fail(function(){
//         alert('通信失敗')
//     })
// })

// 削除の方
// https://qiita.com/u-dai/items/d43e932cd6d96c09b69a
// var より let　のが多い
function deleteEvent(){

    $('#delete-btn').on(click , function(e){

        e.preventDefault();
        let deleteConfirm = confirm('削除しますか？');

        if(deleteConfirm == true){
            let clickEle = $(this);
            // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
            let deleteId = clickEle.data('delete-id');
            console.log(deleteId);

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                // 送信設定～～～～～
                url:'/index',
                type:'POST',
                data:{'_method':'DELETE'}

            }).done(function(data){
                // 実行の内容～～～～～
                console.log('削除出来ました。');
                // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
                clickEle.parents('tr').remove();

                // $('#pr-table').trigger("update");

            }).fail(function(){
                // 失敗の内容～～～～～
                alert('削除失敗')
            });
        }else{
            e.preventDefault();   
        }
    });
}