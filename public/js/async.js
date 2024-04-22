
// 検索の方

$(function(){
    console.log('読み込みOK');
    deleteEvent();
    loadSort();

    $('.search-btn').on('click' , function(e){
        console.log('検索を押す');
        e.preventDefault();

        let formData = $('#serch-form').serialize();

        $.ajax({
            url:'/product',
            type:'GET',
            data:formData,  // formDataは文字列のようにクォーテーション不要
            dataType:'html'

        }).done (function(data){
            console.log('成功しました');
            let newTable = $(data).find('#products-table');
            $('#products-table').replaceWith(newTable);
            loadSort();  // テーブルソーター？使用したら後ほど必要
            deleteEvent();  // ここで再度、deleteEvent関数の「削除イベント」を読み込む

        }).fail (function(){
            alert('通信失敗しました')
        });
    
    });

});

// 削除
// https://qiita.com/u-dai/items/d43e932cd6d96c09b69a
// var より let　のが多い
// https://laraweb.net/tutorial/5405/

$(function(){
    console.log('読み込みました');
})
function loadSort(){
    $('#fav-table').tablesorter({
        headers: {
           1: { sorter: false },
           6: { sorter: false }
        }
    })
}

function  deleteEvent(){

    $.ajaxSetup({
        // headers: {'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')}
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      });
    
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        var deleteConfirm = confirm('削除しますか？');

        if(deleteConfirm == true) {

            var clickEle = $(this);
            // https://www.sejuku.net/blog/37402#index_id0
            // https://qiita.com/EasyCoder/items/1625345ef3a9ce101655
            var deleteId = clickEle.attr('{{$companie->id}}'); 
            
            // clickEle.data カスタムデータ属性？
            // let deleteId = clickEle.data('#delete-id');

            $.ajax({
                // 送信設定～～～～～
                // url:'/index',
                url:'/delete-product',
                // url:'/products',
                
                type:'POST',
                // type:'delete',

                data:{'id': deleteId, '_method':'DELETE'}   //  DELETE リクエストであることを教えている
            })
      
           .done(function() {
              // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
              console.log('削除出来ました');
              clickEle.parents('tr').remove();
            })

            .fail(function() {
                alert('削除失敗しました')
            });
        
        // } else {
        //     (function(e) {
        //         e.preventDefault()
        //     });
        };
    });

}
