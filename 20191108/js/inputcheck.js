var elems = document.getElementsByName("newsel");
for(var i = 0; i <elems.length; i++){
}
function formCheck(){
    var flag = 0;
    var input_text_1_length = document.newrecform.newclassinput.value.length;
    var input_text_2_length = document.newrecform.newclasstype.value.length;
    if ( elems[0].checked==true&&input_text_1_length < 2 ){
        flag = 1;
        document . getElementById( 'notice-input-text-1' ) . innerHTML = "文字数不足です。";
        document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }
    if ( elems[0].checked==true&&input_text_1_length  > 3 ){
        flag = 1;
        document . getElementById( 'notice-input-text-1' ) . innerHTML = "3文字以内でお願いします。";
        document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }
    if ( elems[1].checked==true&&input_text_2_length < 1 ){
        flag = 1;
        document . getElementById( 'notice-input-text-1' ) . innerHTML = "教室タイプ名を入力してください。";
        document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }
    if ( elems[1].checked==true&&input_text_2_length  > 30 ){
        flag = 1;
        document . getElementById( 'notice-input-text-1' ) . innerHTML = "30文字以内でお願いします。";
        document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }
    if( flag ){
        return false;
    }else{
        document . getElementById( 'notice-input-text-1' ) . style . display = "none";
        return true;
    }
}