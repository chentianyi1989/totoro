@extends('member.layouts.main')
@section('content')
<div class="userbasic_wrap">
    <div class="customer_head_toggle">
        <div class="fl">
            报表类型：
            <select onchange="deposit(0,0)" class="report_option">
                <option value="0" @if($type == 0) selected @endif>存款记录</option>
                <option value="1" @if($type == 1) selected @endif>提款记录</option>
                <option value="2" @if($type == 2) selected @endif>额度转换</option>
                <option value="3" @if($type == 3) selected @endif>游戏记录</option>
                <option value="4" @if($type == 4) selected @endif>红利记录</option>
            </select>
        </div>
        <div class="fr time">
            选择日期：
            <!-- <a href="javascript:void(0)" class="active">2017/05</a>
            <a href="javascript:void(0)">2017/04</a>
            <a href="javascript:void(0)">2017/03</a> -->
            <!-- <div class="calanderBox">
              <input readonly="" value="" class="calander" autocomplete="off" name="startTime" id="begTime1">
            </div>
             <div class="calanderBox">
              <input readonly="" value="" class="calander" autocomplete="off" name="endTime" id="endTime1">
            </div> -->

            <input type="text" class="Wdate" id="startTime" onFocus="var endTime=$dp.$('endTime');WdatePicker({onpicked:function(){endTime.focus();},maxDate:'2020-09-22'})"/>
            <input type="text" class="Wdate" id="endTime" onFocus="WdatePicker({onpicked:function(){deposit(this,1);},minDate:'#F{$dp.$D(\'startTime\',{M:0,d:1});}',maxDate:'#F{$dp.$D(\'startTime\',{M:0,d:6});}'})" style="margin-right:0"/>

        </div>
    </div>
    <div class="table_top">
        <table cellspacing="0" cellpadding="0">
            <thead>
           <!--  <th>存款日期</th>
            <th>存款金额</th> -->
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="tcdPageCode tcdPageCode0"></div>
        <div class="tcdPageCode tcdPageCode1"></div>
        <div class="tcdPageCode tcdPageCode2"></div>
        <div class="tcdPageCode tcdPageCode3"></div>
    </div>
</div>

<div class="loading_shadow hide">
  <div class="shadow"></div>
  <img src="{{ asset('/web/images/loading-win8.gif') }}" class="loading_win">
</div>
<script type="text/javascript">

function deposit(obj,type){
    //obj  选择时间控件的时候 obj传递了他本身 this
    //type=0  左侧select选择模式  type=1 右侧时间选择
    //左侧select切换的时候，右侧有默认时间，则请求的时候要带上；
    var optionIndex= $('option:selected', '.report_option').val(); //选中的option的index
    var theadArr=[['存款时间','存款金额','状态'],['提款时间','提款金额','状态'],['转账时间','金额','转出/转入账户','状态'],['平台','投注','输赢','时间'],['红利类型','金额',  '发放时间']];
    //请求的地址1111 以数组存放  一一对应

    var defaultStartTime=$('#startTime').val();  //开始时间内
    var defaultEndTime=$('#endTime').val();   //结束时间

    //存款记录
    //提款记录
    //额度转换
    //游戏记录
    var getUrl=["{{ route('member.rechargeList') }}","{{ route('member.drawingList') }}","{{ route('member.transferList') }}","{{ route('member.gameRecordList') }}","{{ route('member.dividendList') }}"];
    var initPage=false;  //初始状态
    var tbodyHtml='';  //tbody tag
    var theadHtml='';  //thead tag

    

    
    $('.loading_shadow').show();

  
    var getList = function (filter) {
        console.log(optionIndex);

     $.ajax({  
        type : 'GET',
        url : getUrl[optionIndex]+"?page="+filter.page+"&start_at="+defaultStartTime+"&end_at="+defaultEndTime,
        success : function(data){
        $('.loading_shadow').hide();
        var data=data;
         var totalPage=Math.ceil(data.total/data.per_page);
         var currentPage=data.current_page;

         tbodyHtml='';

         if(optionIndex==0){  //存款记录
             var m =0;
          for(var i=0;i<data.data.length;i++){
            tbodyHtml+='<tr>';
            tbodyHtml+='   <td>'+data.data[i].hk_at+'</td>';
            tbodyHtml+='   <td>'+data.data[i].money+'</td>';
            var status = data.data[i].status;
            if (status == 1)
                status = '<span class="status_confirming">待确认</span>';
            else if(status == 2)
                status = '<span class="status_success">充值成功</span>';
            else if(status ==3)
                status = '<span class="status_error">充值失败</span>'
            tbodyHtml+='   <td>'+status+'</td>';
            tbodyHtml+='</tr>';
              m+=Number(data.data[i].money);
          }
             tbodyHtml+='<tr>';
             tbodyHtml+='<td>总和</td>';
             tbodyHtml+='<td>'+m+'元</td>';
             tbodyHtml+='<td></td>';
             tbodyHtml+='</tr>';

         }else if(optionIndex==1){  //提款记录
             var m =0;
             for(var i=0;i<data.data.length;i++){
                 tbodyHtml+='<tr>';
                 tbodyHtml+='   <td>'+data.data[i].created_at+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].money+'</td>';
                 var status = data.data[i].status;
                 if (status == 1)
                     status = '<span class="status_confirming">待确认</span>';
                 else if(status == 2)
                     status = '<span class="status_success">提款成功</span>';
                 else if(status ==3)
                     status = '<span class="status_error">提款失败</span>'
                 tbodyHtml+='   <td>'+status+'</td>';
                 tbodyHtml+='</tr>';
                 m+=Number(data.data[i].money);
             }
             tbodyHtml+='<tr>';
             tbodyHtml+='<td>总和</td>';
             tbodyHtml+='<td>'+m+'元</td>';
             tbodyHtml+='<td></td>';
             tbodyHtml+='</tr>';

         }else if(optionIndex==2){  //额度转换
             var m =0;
             for(var i=0;i<data.data.length;i++){
                 tbodyHtml+='<tr>';
                 tbodyHtml+='   <td>'+data.data[i].created_at+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].money+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].transfer_out_account+'/'+data.data[i].transfer_in_account+'</td>';
                     status = '成功'
                 tbodyHtml+='   <td>'+status+'</td>';
                 tbodyHtml+='</tr>';
                 m+=Number(data.data[i].money);
             }
             tbodyHtml+='<tr>';
             tbodyHtml+='<td>总和</td>';
             tbodyHtml+='<td>'+m+'元</td>';
             tbodyHtml+='<td></td>';
             tbodyHtml+='<td></td>';
             tbodyHtml+='</tr>';
         }else if(optionIndex==3){  //游戏记录
             var m = n =0;
             for(var i=0;i<data.data.length;i++){
                 var type = '';
                 var api_t = data.data[i].api_type;
                 if (api_t == 3)
                     type = 'AG';
                 else if(api_t == 4)
                     type = 'MG';
                 else if(api_t == 5)
                     type = 'BBIN';
                 else if(api_t == 6)
                     type = 'PT';
                 else if(api_t == 7)
                     type = 'PNG';
                 else if(api_t == 8)
                     type = 'OG';
                 else if(api_t == 9)
                     type = 'ALLBET';
                 else if(api_t == 10)
                     type = 'EBET';

                 tbodyHtml+='<tr>';
                 tbodyHtml+='   <td>'+type+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].betAmount+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].netAmount+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].betTime+'</td>';
                 tbodyHtml+='</tr>';
                 m+=Number(data.data[i].betAmount);
                 n+=Number(data.data[i].netAmount);
             }
             tbodyHtml+='<tr>';
             tbodyHtml+='<td>总和</td>';
             tbodyHtml+='<td>'+m+'元</td>';
             tbodyHtml+='<td>'+n+'元</td>';
             tbodyHtml+='<td></td>';
             tbodyHtml+='</tr>';
         }else if(optionIndex==4){  //红利记录
             var m = n =0;
             for(var i=0;i<data.data.length;i++){
                 var type = '';
                 var api_t = data.data[i].type;
                 if (api_t == 1)
                     type = '充值红利';
                 else if(api_t == 2)
                     type = '平台红利';
                 else if(api_t == 3)
                     type = '返水';

                 tbodyHtml+='<tr>';
                 tbodyHtml+='   <td>'+type+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].money+'</td>';
                 tbodyHtml+='   <td>'+data.data[i].created_at+'</td>';
                 tbodyHtml+='</tr>';
                 m+=Number(data.data[i].money);
             }
             tbodyHtml+='<tr>';
             tbodyHtml+='<td>总和</td>';
             tbodyHtml+='<td>'+m+'元</td>';
             tbodyHtml+='<td></td>';
             tbodyHtml+='</tr>';
         }
         
         $('tbody').html(tbodyHtml);

            $('.tcdPageCode').hide().eq(optionIndex).show();
        if (initPage == false) {

          //表头
          for(var m=0;m<theadArr[optionIndex].length;m++){
            theadHtml+='<th>'+theadArr[optionIndex][m]+'</th>';
          }
          $('thead').html(theadHtml);

          $(".tcdPageCode"+optionIndex).createPage({
            pageCount: totalPage,
            current: currentPage,
            backFn: function (p) {
              $('.loading_shadow').show();
              search(p);
            }
          });
          $('.loading_shadow').hide();
          initPage = true;
        } else {

          $(".tcdPageCode"+optionIndex).createPage({
            pageCount: totalPage,
            current: filter.page,
            backFn:function(){
              $('.loading_shadow').show();
            }
          });
          $('.loading_shadow').hide();
        }
    }
      })
    };

    var search = function (p,type) {
      var filter = {
        page: p
      }

      getList(filter);
      
    };

    search(1);
}
    
deposit();

function dateAjax(nowDate){
  console.log(nowDate.value);
  console.log($('#startTime').val());
}

//日期选择

</script>
    @endsection
