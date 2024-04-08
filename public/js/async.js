
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
// https://laraweb.net/tutorial/5405/

$(function(){
    console.log('読み込みました');
})

$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
    }
  });

$(function() {
    $('#delete-btn').on('click', function() {
        var deleteConfirm = confirm('削除しますか？');

        if(deleteConfirm == true) {

            var clickEle = $(this);
            // https://www.sejuku.net/blog/37402#index_id0
            var deleteId = clickEle.attr('#delete-id');
            
            // clickEle.data カスタムデータ属性？
            // let deleteId = clickEle.data('#delete-id');

            $.ajax({
                // 送信設定～～～～～
                url:'/index',
                type:'POST',
                data:{'_method':'DELETE'}   //  DELETE リクエストであることを教えている
            })
      
           .done(function() {
              // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
              console.log('削除出来ました');
              clickEle.parents('tr').remove();
            })

            .fail(function() {
                alert('削除失敗しました')
            });
        
        } else {
            (function(e) {
                e.preventDefault()
            });
        };
    });
});

