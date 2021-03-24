<?php
?>
<!--type="submit" class="addbtn" class="clickable" id="AddNeww" name="addnewcategory"-->
<div>
        <input id='NewOne' type="text" name="newcategory" value="" required>
        <button type="submit" id="AddNeww"   >ADD</button>
</div>
<div name="groupUl" class="CategoriesUldiv">
    <ul class="sTree2 listsClass ulNivo " id="sTree2">
        <!--<div style="text-align:right">
            <input id='NewOne1' type="text" name="newcategory" value="" required>
            <span id="add_subject" class="clickable fa fa-plus addbtn" title="add a subject"> </span></div>-->
<?php
    $orderby = 'name';
    $order = 'asc';
    $hide_empty = false ;
    $cat_args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
        'parent' => '0',
    );
    $product_categories = get_terms( 'product_cat', $cat_args );
    if( !empty($product_categories) ) {
        /*echo '<ol id="sortable" name="sortable" data-draggable="target" >';*/
        foreach ($product_categories as $key => $category) {


                $IDbyNAME = get_term_by('name', $category->name, 'product_cat');
                 $product_cat_ID = $IDbyNAME->term_id;
                 $args = array(
                    'hierarchical' => 1,
                    'show_option_none' => '',
                    'hide_empty' => false,
                    'parent' => $product_cat_ID,
                    'taxonomy' => 'product_cat'
                  );
                 $subcats = get_categories($args);
                 if($subcats!=NULL) {
                     echo '<li class="liNivo s-l-open" id="'.$category->term_id.'" data-module="a">
                                <div>'.$category->name.'<span  class="clickable deletebtn" > X</span></div>';
                     echo '<ul class="ulNivo" style="display: block;">';
                     foreach ($subcats as $sc) {

                         $IDbyNAME2 = get_term_by('name', $sc->name, 'product_cat');
                         $product_cat_ID2 = $IDbyNAME2->term_id;
                         $args4 = array(
                             'hierarchical' => 1,
                             'show_option_none' => '',
                             'hide_empty' => false,
                             'parent' => $product_cat_ID2,
                             'taxonomy' => 'product_cat'
                         );
                         $subcats3 = get_categories($args4);
                         if($subcats3!=NULL){

                            echo '<li class="liNivo s-l-open" id="'.$sc->term_id.'" data-module="a">
                                         <div>'.$sc->name.'<span class="clickable deletebtn" > X</span></div>
                                     ';
                             echo '<ul class="ulNivo" style="display: block;">';
                             foreach ($subcats3 as $scs) {

                                 echo '<li class="liNivo" id="'.$scs->term_id.'" data-module="a">
                                         <div>'.$scs->name.'<span class="clickable deletebtn" > X</span></div>
                                     </li>';
                             }
                             echo '</ul>';
                         }else{
                             echo '<li class="liNivo" id="'.$sc->term_id.'" data-module="a">
                                         <div>'.$sc->name.'<span class="clickable deletebtn" > X</span></div>
                                     </li>';};


                     }
                     echo '</ul>';
                 }else{
                     echo '<li class="liNivo" id="'.$category->term_id.'" data-module="a">
                                         <div>'.$category->name.'<span class="clickable deletebtn" > X</span></div>
                                     </li>';
            }
        }

    }
?>
    </ul>
</div>
<div>
    <button class="saveButtonCategories">SAVE</button>
</div>
<span id="toArrBtn" class="btn toArray">To array</span>


<script type="text/javascript">
    $( ".clickable" ).hover(
        function() {
            $( this ).append( $( "<span> ***</span>" ) );
        }, function() {
            $( this ).find( "span" ).last().remove();
        }
    );
    $('document').ready(function()
    {
        /*let test = document.getElementsByClassName("clickable");

// This handler will be executed only once when the cursor
// moves over the unordered list
        test.addEventListener("mouseenter", function( event ) {
            // highlight the mouseenter target
            event.target.style.color = "red";
        })*/
        $('.clickable').hover (

            function () {
                $(this).parent().parent().toggleClass('clickableee');
                /*$(this).closest("li").addClass('clickableee');*/

            });

       /* $('.clickable').on('click', function(e)	{ $(this).closest("li").remove(); });*/
        var options = {
            placeholderCss: {'background-color': '#ff8'},
            hintCss: {'background-color':'#bbf'},
            listSelector: 'ul',
            maxLevels:  3,
            drop: true,
            insertZonePlus: true,
            onChange: function( cEl )
            {

                console.log( 'onChange' );
            },
            complete: function( cEl )
            {
                console.log(  $('#sTree2 ul').maxlength );
                console.log(  cEl.parent().parent().parent().parent().parent().parent().parent().attr('id') );
            },
            onSort: function (/**Event*/evt) {
                // same properties as onEnd
                $('#sTree2').sortableLists( 'refresh' );
            },
            isAllowed: function( cEl, hint, target )
            {
                // Be carefull if you test some ul/ol elements here.
                // Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
                // Be careful also if the hint is not visible. It has only display none so it is at the previous place where it was before(excluding first moves before showing).
               /* if( target.data('module') === 'c' || cEl.data('module') == 'c') //only answers can go in questions
                  {
//console.log('a subject or a question may not be placed in a question');
                    hint.css('background-color', '#ff9999');
                    return false;
                }
                else
                {
                    hint.css('background-color', '#99ff99');
                    return true;
                }
                if(target.parentNode().eq(5).attr('id') === 'sTree2'|| cEl.parentNode().eq(5).attr('id') === 'sTree2' ){
                    hint.css('background-color', '#99fffc');
                    return false;
                }*//*else{
                    hint.css('background-color', '#99b3ff');
                    return true;
                }*/
               /* if (cEl.children().length > 1) {
                alert("More than 1!");
                // move item back to main_list
              /!*  $(ui.sender).sortable('cancel');*!/
                    hint.css('background-color', '#ff9999');
                    return false;
            }*/
                /*if( cEl.parent().parent().parent().parent().parent().attr('id')  == 'sTree2')//nothing can be placed inside answers
                {
                    //console.log('refuse to sub in answer');
                    hint.css('background-color', '#ff9999');
                    return false;
                }*/
                cEl.find( 'li' ).each( function()
                {
                    if(li.parent().parent().parent().parent().parent().parent().parent().attr('id')  === 'sTree2'){
                        console.log('nemoze');
                        hint.css('background-color', '#ff9999');
                        return false;
                    }else{
                        hint.css('background-color', '#99ff99');
                        return true;
                    }

                })

                if(hint.parent().parent().parent().parent().parent().parent().parent().attr('id')  === 'sTree2'|| cEl.parent().parent().parent().parent().parent().parent().parent().attr('id')  === 'sTree2' )
                {
                    console.log('nemoze');
                    hint.css('background-color', '#ff9999');
                    return false;
                }
                else
                {
                    hint.css('background-color', '#99ff99');
                    return true;
                }
            },
            opener: {
                active: true,
                as: 'html',  // if as is not set plugin uses background image
                close: '<i class="fa fa-minus c3"></i>',  // or 'fa-minus c3'
                open: '<i class="fa fa-plus"></i>',  // or 'fa-plus'
                openerCss: {
                    'display': 'inline-block',
                    //'width': '18px', 'height': '18px',
                    'float': 'left',
                    'margin-left': '-35px',
                    'margin-right': '5px',
                    'background-position': 'center center', 'background-repeat': 'no-repeat',
                    'font-size': '1.1em'
                }
            },
            ignoreClass: 'clickable',
            addClass: 'addbtn',
            removeClass: 'deletebtn'
        };

        var optionsPlus = {
            insertZonePlus: true,
            placeholderCss: {'background-color': '#ff8'},
            hintCss: {'background-color':'#bbf'},
            opener: {
                active: true,
                as: 'html',  // if as is not set plugin uses background image
                close: '<i class="fa fa-minus c3"></i>',
                open: '<i class="fa fa-plus"></i>',
                openerCss: {
                    'display': 'inline-block',
                    'float': 'left',
                    'margin-left': '-35px',
                    'margin-right': '5px',
                    'font-size': '1.1em'
                }
            }
        };

        $('#sTree2').sortableLists( options );
        $('#sTreePlus').sortableLists( optionsPlus );

        $('#toArrBtn').on( 'click', function(){ console.log( $('#sTree2').sortableListsToArray() ); } );
       /* $('#toHierBtn').on( 'click', function() { console.log( $('#sTree2').sortableListsToHierarchy() ); } );
        $('#toStrBtn').on( 'click', function() { console.log( $('#sTree2').sortableListsToString() ); } );*/
        $('.descPicture').on( 'click', function(e) { $(this).toggleClass('descPictureClose'); } );



        /* Scrolling anchors */
        $('#toPictureAnch').on( 'mousedown', function( e ) { scrollToAnch( 'pictureAnch' ); return false; } );
        $('#toBaseElementAnch').on( 'mousedown', function( e ) { scrollToAnch( 'baseElementAnch' ); return false; } );
        $('#toBaseElementAnch2').on( 'mousedown', function( e ) { scrollToAnch( 'baseElementAnch' ); return false; } );
        $('#toCssPatternAnch').on( 'mousedown', function( e ) { scrollToAnch( 'cssPatternAnch' ); return false; } );
        $('.clickable').on('click', function(e)	{ $(this).closest("li").remove(); });
        $('.clickable').on('mouseenter', function(e)	{  $(this).closest("li").addClass('clickableee'); });
        $('.clickable').on('mouseleave', function(e)	{  $(this).closest("li").removeClass('clickableee'); });

        $('#AddNeww').on('click', function(e)	{
            var NewOne = document.getElementById('NewOne').value;
            if (NewOne == null || NewOne == "") {
                alert("Please Fill All Required Field");
                return false;
            }else{
                let ok = true;
                if (ok === true) {
                    var li = document.createElement('li');
                    var span = document.createElement('span');
                    var div =document.createElement('div');
                    li.setAttribute("class", 'liNivo');
                    li.setAttribute("style", "unset");
                    div.innerText=document.getElementById("NewOne").value;
                    var lis= [];
                    const ul = document.getElementById('sTree2');
                    const listItems = ul.getElementsByTagName('li');
                    for (let i = 0; i <= listItems.length - 1; i++) {
                        lis.push(listItems[i].id);
                    }
                    var id= Math.max.apply(null, lis);
                    id=id+1;
                    /* li.element.style.cssText ="";*/
                    li.setAttribute("id", id);
                    li.setAttribute("data-module", "a");
                    span.setAttribute("id", "del_question");


                    span.setAttribute("class", "clickable deletebtn");


                    span.innerText="X";
                    div.appendChild(span);
                    li.appendChild(div);
                    /*let ulNivo=document.getElementById("sTree2");*/
/*
                    document.getElementById("sTree2").prepend(li);*/
                 /*   document.getElementById("sTree2").prepend(li);*/
                   /* $('#sTree2').sortable.create(li);*/
                    /*$('#sTree2').sortableLists( 'refresh' );*/
                    $("#sTree2:eq(0)").prepend(li);

                /*    $( "#sTree2" ).sortable( "destroy" );*/
                   /* $( "#sTree2" ).opener.html( setting.opener.close );*/
                   /* location.reload(true);*/
                    /*$('#sTree2').SortableDestroy();*/
                    /*new sortableLists($("#sTree2"));*/
                   /* $("#sTree2").sortableLists( options).init();*/
                    /*sortable({
                        connectWith: "#sTree2"
                    }).disableSelection();*/



               /*     document.getElementById("sTree2").prepend(li).sortable({
                        connectWith: "sTree2"
                    }).disableSelection();*/
                }
                }
            /*$("#sTree2").sortable({
                connectWith: "#sTree2"
            }).disableSelection();*/
    });
        $('.clickable').on('click', function(e)	{ $(this).closest("li").remove(); });

                /*var target = $( e.target );
                //dodatak
                console.log('usli u ovaj novi');
                if ( ( setting.addClass && target.hasClass( setting.addClass ) ) )
                {
                    console.log("usli u add buton");

                    console.log("someone touched the add button");
                    if(target[0].id=="add_subject"){
                        var li = document.createElement('li');
                        var span = document.createElement('span');
                        var div =document.createElement('div');
                        li.setAttribute("class", 'liNivo');
                        li.setAttribute("style", "unset");
                        div.innerText=document.getElementById("NewOne").value;
                        var lis= [];
                        const ul = document.getElementById('sTree2');
                        const listItems = ul.getElementsByTagName('li');
                        for (let i = 0; i <= listItems.length - 1; i++) {
                            lis.push(listItems[i].id);
                        }
                        var id= Math.max.apply(null, lis);
                        id=id+1;
                        /!* li.element.style.cssText ="";*!/
                        li.setAttribute("id", id);
                        li.setAttribute("data-module", "a");
                        span.setAttribute("class", "clickable");
                        span.setAttribute("onclick", "remove()");
                        span.innerText="X";
                        div.appendChild(span);
                        li.appendChild(div);
// console.log("it is the add subject button");

                        var new_subject_element =li;
                        console.log(new_subject_element);
                        var test=$("#sTree2").append(new_subject_element);
                    }
                    else if(target[0].id=="add_question"){
// console.log("it is the add question button");

//if the parent we want to place in does not contain a ul element, it is the first listitem inside this subject block so we create it with an ul
                        var new_question_element_with_ul ='<ul class="pten"><li class="bgC6 questionstyle" id="item_new" data-module="question"> '+
                            '<div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 3</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>'+
                            '</li></ul>';
//else we append to the existing ul element.
                        var new_question_element ='<li class="bgC6 questionstyle" id="item_new" data-module="question">'+
                            '<div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 3</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>'+
                            '</li>';

                        var question_dropzone = $(target.context.parentNode.parentNode);
                        if(question_dropzone.children('ul').length == 1)
                        {
                            var firstul=question_dropzone.children('ul').first();
                            firstul.append(new_question_element); //add question to the existing ul element of this subject
                        }
                        else{
                            question_dropzone.append(new_question_element_with_ul); //ad a new ul element with question to this subject
                        }

                    }
                    else if(target[0].id=="add_answer"){
                        console.log("it is the add answer button");

//if the parent we want to place in does not contain a ul element, it is the first listitem inside this subject block so we create it with an ul
                        var new_answer_element_with_ul ='<ul class="pten"><li class="bgC7 answerstyle" id="item_5" data-module="answer">'+
                            '<div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 5</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>'+
                            '</li></ul>';
//else we append to the existing ul element.
                        var new_answer_element ='<li class="bgC7 answerstyle" id="item_5" data-module="answer">'+
                            '<div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 5</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>'+
                            '</li>';
                        var answer_dropzone = $(target.context.parentNode.parentNode);
                        if(answer_dropzone.children('ul').length == 1)
                        {
                            var firstul=answer_dropzone.children('ul').first();
                            firstul.append(new_answer_element); //add question to the existing ul element of this subject
                        }
                        else{
                            answer_dropzone.append(new_answer_element_with_ul); //ad a new ul element with question to this subject
                        }

                    }
// console.log(target);

                    tidyFilledLists();

                    setting.complete(); // to trigger there is something changed and the output array can be shown.
                    return;
                }

                if ( state.isDragged !== false || ( setting.removeClass && target.hasClass( setting.removeClass ) ) )
                {
                    console.log("someone touched the delete button");
                    if(target[0].id=="del_subject"){
                        console.log("it is the delete subject button");
                        var removed= target.context.parentNode.parentNode.remove();
//$(this).parent().remove();
                    }
                    else if(target[0].id=="del_question"){
                        console.log("it is the delete question button");
                        console.log(target.context.parentNode.parentNode.id);
                        var removed= target.context.parentNode.parentNode.remove();
                    }
                    else if(target[0].id=="del_answer"){
                        console.log("it is the delete answer button");
                        var removed= target.context.parentNode.parentNode.remove();
                    }
                    console.log(target);

                    tidyEmptyLists();
                    setting.complete(); // to trigger there is something changed and the output array can be shown.

                    return;
                }
                //kraj dodatka
                if ( state.isDragged !== false || ( setting.ignoreClass && target.hasClass( setting.ignoreClass ) ) ) return; // setting.ignoreClass is checked cause hasClass('') returns true

                // Solves selection/range highlighting
                e.preventDefault();

                // El must be li in jQuery object
                var el = target.closest( 'li' ),
                    rEl = $( this );

                // Check if el is not empty
                if ( el[0] )
                {
                    setting.onDragStart( e, el );
                    startDrag( e, el, rEl );
                }
            }
        );*/

        function scrollToAnch( id )
        {
            return true;
            $('html, body').animate({
                scrollTop: '-=-' + $("#" + id).offset().top + 'px'
            }, 750);
            return false;
        }

    });
    document.getElementById('del_question').addEventListener("click", deleteLi, false);
    function deleteLi(){
        $(this).closest("li").remove();
    }
</script>



    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!--<style>
    /* http://camohub.github.io/jquery-sortable-lists/index.html */
    .subjectstyle { list-style-type: none; padding: 3px 3px 3px 50px; margin: 10px 0; color: #fff; border-radius: 3px; border: 1px solid #000; }
    .subjectdiv { padding: 7px;  background-color: #D870A9; border: 1px solid #000; border-radius: 3px;}
    .questionstyle {padding: 3px 3px 3px 50px; margin: 10px 0;  border-radius: 3px; list-style-type: none;color: #fff; border-radius: 3px; border: 1px solid #000; }
    .questiondiv { padding: 7px; background-color: #D870A9; border: 1px solid #000; border-radius: 3px;}
    .answerstyle { list-style-type: none; padding: 3px 3px 3px 50px; margin: 10px 0; color: #fff; border-radius: 3px; border-radius: 3px; border: 1px solid #000; }
    .answerdiv { padding: 7px; background-color: #D870A9; color:#fff; border: 1px solid #000; border-radius: 3px;}
    .pten { padding:10px;}
    .noselect {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
    }
    .dragbar { margin-left:-50px; float:left; }
    .grab {
        cursor: -webkit-grab;
        cursor: grab;
    }
    .addbtn { color:#000;  }
    .btnpadding { float:right; padding-right:2px; padding-left:2px;}
    .deletebtn { color:red; }
    .scrollUp { position:fixed; top:0; left:0; height:48px; width:50px; border:1px solid red; }
    .scrollDown { position:fixed; bottom:0; left:0; height:48px; width:50px; border:1px solid red; }
    .dN { display:none; }
    .bgC5 { background-color:#ED87BD; }
    .bgC6 { background-color:#ED87BD; }
    .bgC7 { background-color:#ED87BD; }
    .small1 { font-size:0.8em; }
    .small2 { font-size:0.7em; }
    .small3 { font-size:0.6em; }
    #sTree2 { margin:10px 0; background-color: #ED87BD; border: 1px solid #000; border-radius: 3px; }
    #center { max-width:950px; margin:0 auto; padding:10px; }
</style>
    <script type="text/javascript">
        $(function()
        {
            var options = {
                placeholderCss: {'background-color': '#ff8'},
                hintCss: {'background-color':'#bbf'},
                onChange: function( cEl )
                {
                    console.log( 'onChange' );
                },
                complete: function( cEl )
                {
                    console.log( 'complete' );
                    //   console.log($('#sTree2').sortableListsToArray());
                    //   console.log($('#sTree2').sortableListsToHierarchy());
                    //   console.log($('#sTree2').sortableListsToString());

                },
                isAllowed: function( cEl, hint, target )
                {
                    // Be carefull if you test some ul/ol elements here.
                    // Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
                    // Be careful also if the hint is not visible. It has only display none so it is at the previouse place where it was before(excluding first moves before showing).


                    if( target.data('module') === 'answer')//nothing can be placed inside answers
                    {
                        //console.log('refuse to sub in answer');
                        hint.css('background-color', '#ff9999');
                        return false;
                    }
                    else if(cEl.data('module') !== 'subject' && typeof target.data('module')=== 'undefined') //only subjects can go in a list.
                    {
                        //console.log('only subject may be placed here');
                        hint.css('background-color', '#ff9999');
                        return false;
                    }
                    else if( target.data('module') === 'subject' && ( cEl.data('module') == 'subject' || cEl.data('module') == 'answer' )) //only questions can go into subjects
                    {
                        //console.log('a subject or an answer may not be placed in a subject');
                        hint.css('background-color', '#ff9999');
                        return false;
                    }
                    else if( target.data('module') === 'question' && (cEl.data('module') == 'subject' || cEl.data('module') == 'question' )) //only answers can go in questions
                    {
                        //console.log('a subject or a question may not be placed in a question');
                        hint.css('background-color', '#ff9999');
                        return false;
                    }
                    else

                        hint.css('background-color', '#99ff99');
                        return true;


                },
                opener: {
                    active: true,
                    as: 'html',  // if as is not set plugin uses background image
                    close: '<i class="fa fa-minus c3"></i>',  // or 'fa-minus c3',  // or './imgs/Remove2.png',
                    open: '<i class="fa fa-plus"></i>',  // or 'fa-plus',  // or'./imgs/Add2.png',
                    openerCss: {
                        'display': 'inline-block',
                        //'width': '18px', 'height': '18px',
                        'float': 'left',
                        'margin-left': '-35px',
                        'margin-right': '5px',
                        //'background-position': 'center center', 'background-repeat': 'no-repeat',
                        'font-size': '1.1em'
                    }
                },
                ignoreClass: 'clickable',
                addClass: 'addbtn',
                removeClass: 'deletebtn'
            };
            $('#sTree2').sortableLists(options);

            console.log($('#sTree2').sortableListsToArray());
            console.log($('#sTree2').sortableListsToHierarchy());
            console.log($('#sTree2').sortableListsToString());
        });
    </script>
</head>
<body>



<div id="center" class="listsorter">

    <ul class="sTree pten" id="sTree2">
        <div style="text-align:right"><span id="add_subject" class="clickable fa fa-plus addbtn" title="add a subject"> </span></div>
        <!-- subject -->
        <li class="bgC5 subjectstyle" id="item_a" data-module="subject">
            <div class="subjectdiv"><span class="noselect dragbar grab">||</span><span>subject a</span><span id="del_subject" class="clickable fa fa-trash deletebtn btnpadding" title="delete this subject"></span><span id="add_question" class="clickable fa fa-plus addbtn btnpadding" title="add a question"></span></div>
        </li>
        <!-- subject -->
        <li class="bgC5 subjectstyle" id="item_b" data-module="subject">
            <div class="subjectdiv"><span class="noselect dragbar grab">||</span><span>subject b</span><span id="del_subject" class="clickable fa fa-trash deletebtn btnpadding" title="delete this subject"></span><span id="add_question" class="clickable fa fa-plus addbtn btnpadding" title="add a question"></span></div>
        </li>
        <!-- subject -->
        <li class="bgC5 subjectstyle" id="item_c" data-module="subject">
            <div class="subjectdiv"><span class="noselect dragbar grab">||</span><span>subject c</span><span id="del_subject" class="clickable fa fa-trash deletebtn btnpadding" title="delete this subject"></span><span id="add_question" class="clickable fa fa-plus addbtn btnpadding" title="add a question"></span></div>
            <ul class="pten">
                <li class="bgC6 questionstyle" id="item_1" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 1</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_2" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 2</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                    <ul class="pten">
                        <li class="bgC7 answerstyle" id="item_1" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 1</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_2" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 2</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_3" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 3</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_4" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 4</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_5" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 5</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                    </ul>
                </li>
                <li class="bgC6 questionstyle" id="item_3" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 3</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_4" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 4</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_5" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 5</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
            </ul>
        </li>
        <!-- subject -->
        <li class="bgC5 subjectstyle" id="item_d" data-module="subject">
            <div class="subjectdiv"><span class="noselect dragbar grab">||</span><span>subject d</span><span id="del_subject" class="clickable fa fa-trash deletebtn btnpadding" title="delete this subject"></span><span id="add_question" class="clickable fa fa-plus addbtn btnpadding" title="add a question"></span></div>
            <ul class="pten">
                <li class="bgC6 questionstyle" id="item_1" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 1</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                    <ul class="pten">
                        <li class="bgC7 answerstyle" id="item_1" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 1</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_2" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 2</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_3" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 3</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_4" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 4</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                        <li class="bgC7 answerstyle" id="item_5" data-module="answer">
                            <div class="answerdiv"><span class="noselect dragbar grab">||</span><span>answer 5</span><span id="del_answer" class="clickable fa fa-trash deletebtn btnpadding" title="delete this answer"></span></div>
                        </li>
                    </ul>
                </li>
                <li class="bgC6 questionstyle" id="item_2" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 2</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_3" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 3</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_4" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 4</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_5" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 5</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
            </ul>
        </li>
        <!-- subject -->
        <li class="bgC5 subjectstyle" id="item_e" data-module="subject">
            <div class="subjectdiv"><span class="noselect dragbar grab">||</span><span>subject e</span><span id="del_subject" class="clickable fa fa-trash deletebtn btnpadding" title="delete this subject"></span><span id="add_question" class="clickable fa fa-plus addbtn btnpadding" title="add a question"></span></div>
            <ul class="pten">
                <li class="bgC6 questionstyle" id="item_1" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 1</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_2" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 2</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_3" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 3</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_4" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 4</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
                <li class="bgC6 questionstyle" id="item_5" data-module="question">
                    <div class="questiondiv"><span class="noselect dragbar grab">||</span><span>question 5</span><span id="del_question" class="clickable fa fa-trash deletebtn btnpadding" title="delete this question"></span><span id="add_answer" class="clickable fa fa-plus addbtn btnpadding" title="add an answer"></span></div>
                </li>
            </ul>
        </li>
    </ul>

    <div class="scrollUp dN"></div>
    <div class="scrollDown dN"></div>

</div>


</body>
</html>-->

