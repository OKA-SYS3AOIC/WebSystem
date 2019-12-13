function checkForm2($this)
{
    var str=$this.value;
    while(str.match(/[!"#$%&'()*,\-.\/:;<>?@\[\\\]\^_`{|}~]/))
    {
        str=str.replace(/[!"#$%&'()*,\-.\/:;<>?@\[\\\]\^_`{|}~]/,"");
    }
    $this.value=str;
}