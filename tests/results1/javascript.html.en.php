<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src='somefile/<?php echo htmlspecialchars($t->js_file);?>'></script>



</head>

<script language="javascript">

// some sample javascript that might cause problemss

function CheckDuplicates (AddListContainer, RemoveListContainer) { 
    var AddList = eval('document.main_form.'+AddListContainer); 
    var RemoveList = eval('document.main_form.'+RemoveListContainer); 
    var TempAddList = AddList.value; 
    var TempRemoveList = RemoveList.value; 
    if (TempAddList>''&&TempRemoveList>'') { 
        TempAddList = TempAddList.substring(0,TempAddList.length-1); 
    }
}

//<!-- 

function CheckDuplicates2 (AddListContainer, RemoveListContainer) { 
    var AddList = eval('document.main_form.'+AddListContainer); 
    var RemoveList = eval('document.main_form.'+RemoveListContainer); 
    var TempAddList = AddList.value; 
    var TempRemoveList = RemoveList.value; 
    if (TempAddList>''&&TempRemoveList>'') { 
        TempAddList = TempAddList.substring(0,TempAddList.length-1); 
    }
}


-->
 
</script>

<!--

// and now just commented out stuff.. that may cause problems

function CheckDuplicates (AddListContainer, RemoveListContainer) { 
    var AddList = eval('document.main_form.'+AddListContainer); 
    var RemoveList = eval('document.main_form.'+RemoveListContainer); 
    var TempAddList = AddList.value; 
    var TempRemoveList = RemoveList.value; 
    if (TempAddList>''&&TempRemoveList>'') { 
        TempAddList = TempAddList.substring(0,TempAddList.length-1); 
    }
}
 
--> 
<script type="application/x-javascript" src="js/common.js"></script>
<script type="application/x-javascript" src="../searchjs.php"></script>
<script type="application/x-javascript" src="js/catctrl.js"></script>
<script type="application/x-javascript">
                function productAddApply() {
                        req = new phpRequest(URI_CONTROL + "/New/product");
                        req.add("product_category", get_value("listProdCat"));
                        req.add("item_category", get_value("listItemCat"));
                        req.add("item_subcategory", get_value("listItemSubCat"));
                        req.add("supplier_id", get_value("listSupplier"));
                        req.add("supplier_model_numb", get_value("txtSupModelNo"));
                        req.add("article", get_value("txtArtDescr"));
                        req.add("material", get_value("txtMaterial"));
                        req.add("color", get_value("txtColor"));
                }
</script>
<body> 


</body>
</html>