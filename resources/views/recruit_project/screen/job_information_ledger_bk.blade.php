@extends('recruit_project.common.layouts_ledger')

@section('pagehead')
@section('title', '求人レポート')  
@endsection
@section('content')

<style>


@media screen {
    
    body {
        background: #eee;
    }
    .sheet {
        background: white; /* 背景を白く */
        box-shadow: 0 .5mm 2mm rgba(0,0,0,.3); /* ドロップシャドウ */
        margin: 5mm;
    }
}


@page {

    /* 縦 */
    size: A4 portrait;

    /* 横 */
    /* size: A4 landscape; */    
    margin: 0mm;
}
*{
    margin: 0mm;
    padding: 0mm;
}

@media print{
    .header-area{
        display: none;
    }
}

.header-area{
  width: 100%;
  margin: 3px 0;  
  text-align: right;  
}



.print-button{
  margin: 5px 5px 0 0;
}

.sheet-area{
  display: flex;
  justify-content: center;
}

.sheet {
    height: 297mm;
    width: 210mm;
    page-break-after: always;
    box-sizing: border-box;
    padding: 20mm 25mm;
    font-size: 11pt;
}





/* ============================================ */

.txt__right{
    text-align: right;
}
.txt__center{
    text-align: center;
}
.txt_underline{
    text-decoration: underline;
}


.name{
    font-size: 12pt;
}
.caption{
    font-size: 9pt;
}
.bank{
    margin-bottom: 1em;
}

h1{
    margin: 1em 0;
    font-size: 16pt;
    letter-spacing: 0.2em;
}

.price{
    display: flex;
    border: solid 0.5pt #000;
    font-size: 14pt;
    max-width: 60%;
    margin: 1em 0 2em;
}
.price dt, .price dd{
    padding: 1em;
}
.price dt{
    border-right: solid 0.5pt #000;
}

table{
    width: 100%;
    border-collapse: collapse;
}
th, td{
    border: solid 0.5pt #000;
    padding:0.1em;
}
thead,
tfoot th{
    background: #ccc;
}

tfoot td:empty{
    border: none;
}

.item-center{
  display: flex;
  justify-content: center; /*左右中央揃え*/
  align-items: center;     /*上下中央揃え*/
}



</style>


<div class="header-area">
  
    <button class="btn btn-primary print-button">
      <i class="fas fa-file-import"></i>
      印刷
    </button>
  
</div>

<div class="sheet-area">
  
  <section class="sheet">
    <p class="caption txt__right">
        2021年2月14日
    </p>
    <p class="name txt_underline">
        Example 御中
    </p>
    <p class="name txt__right">
        Example Example
    </p>
    <p class="caption txt__right">
        東京都○○区○○1-2-3<br>
        ○○　○○<br>
        00-0000-0000
    </p>

    <h1 class="txt__center">
        御請求書
    </h1>
    <p>
        なんとかにつき下記のとおりご請求申し上げます。
    </p>

    <dl class="price">
        <dt>
            ご請求金額
        </dt>
        <dd>
            10,000 円
        </dd>
    </dl>

    <table>
        <thead>
        <tr>
            <th>NO</th>
            <th>品名</th>
            <th>数量</th>
            <th>単価</th>
            <th>合計</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th width="30">1</th>
            <td></td>
            <td width="50"></td>
            <td width="100"></td>
            <td width="150"></td>
        </tr>
        <tr>
            <th>2</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>3</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>4</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>5</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>6</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>7</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>8</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>9</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3"></td>
            <th>小計</th>
            <td>10,000円</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <th>消費税</th>
            <td>10,000円</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <th>合計</th>
            <td>10,000円</td>
        </tr>
        </tfoot>
    </table>
    <p class="bank">
        銀行名： ○○銀行　○○支店<br>
        口座番号： 普通　0000000<br>
        口座名義： ○○○○
    </p>
    <p>
        以上、よろしくお願いいたします。
    </p>
  </section>

      
</div>


@endsection

@section('pagejs')

<script type="text/javascript">



$(document).on("click", ".print-button", function (e) {

    window.print();

})

$(document).ready(function () {


    // window.print();
    // window.close();


})


</script>
@endsection

