/**
 * Created by danielgontar on 5/27/17.
 */
function print_lead()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=lead",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200) && (xhr.readyState==4))
        {
            child.innerHTML = xhr.response;
        }
    };
    xhr.send(null);
    page.appendChild(child);

}
function print_arch_lead()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=arch_lead",true);
    xhr.onreadystatechange=function()
    {
        child.innerHTML = xhr.response;
    };
    page.appendChild(child);
    xhr.send(null);
}
// next page display in print archive lead
function next_print_arch_lead()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=arch_lead_next",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status == 200) && (xhr.readyState == 4))
        {
            //console.log(xhr.response);
            child.innerHTML = xhr.response;
        }
    };
    page.appendChild(child);
    xhr.send(null);
}
// prev page display in print archive lead
function prev_print_arch_lead()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=arch_lead_prev",true);
    xhr.onreadystatechange=function()
    {

        if ((xhr.status == 200) && (xhr.readyState == 4))
        {
           //console.log(xhr.response);
            child.innerHTML = xhr.response;
        }

    };
    page.appendChild(child);
    xhr.send(null);
}

// sends lead to archive
function archive_lead(id)
{
    var xhr;
    xhr = new XMLHttpRequest();
    xhr.abort();
    xhr.open("GET","../archive_data.php?lead="+id,true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200) && (xhr.readyState==4))
        {
            console.log(xhr.response);
        }
    };
    xhr.send(null);

    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    child.innerHTML = '<div style="margin:150px 43%"><img src="../assets/sw1.jpeg"></div>';
    page.appendChild(child);

    // delay before re- printing the leads..
    var timesRun = 0;
    var interval = setInterval(function()
    {
        timesRun += 1;
        if(timesRun == 1)
        {
            clearInterval(interval);
        }
        print_lead();
    }, 3000);

}
function archive_order(id)
{
    var page = document.getElementById('page');
    page.innerHTML='';

    var xhr;
    xhr = new XMLHttpRequest();
    xhr.abort();
    xhr.open("GET","../archive_data.php?order="+id,true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200) && (xhr.readyState==4))
        {
            console.log(xhr.response);
        }
    };
    xhr.send(null);

    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    child.innerHTML = '<div style="margin:200px 48%"><img src="../assets/sw1.jpeg"></div>';
    page.appendChild(child);

    // delay before re- printing the leads..
    var timesRun = 0;
    var interval = setInterval(function()
    {
        timesRun += 1;
        if(timesRun == 1)
        {
            clearInterval(interval);
        }
        display_orders();
    }, 3000);
}
function logout()
{
    window.location.assign("http://backend.delikates.co.il");
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../logout.php",true);
    xhr.onreadystatechange=function()
    {
       console.log(xhr.response);
    };
    xhr.send(null);
}
function print_graph()
{
    var page = document.getElementById('page');
    page.innerHTML='';

// first graph

    row1 = document.createElement('div');
    row1.className = 'row';

    col11 = document.createElement('div');
    col11.className = 'col-lg-2';
    row1.appendChild(col11);

    vis1 = document.createElement('div');
    vis1.className = 'col-lg-8';
    vis1.id = 'vis1';
    vis1.style="width:90%;height:70%;max-height:220px";
    row1.appendChild(vis1);
    page.appendChild(row1);

// second graph
    row2 = document.createElement('div');
    row2.className = 'row';

    col21 = document.createElement('div');
    col21.className = 'col-lg-2';
    row2.appendChild(col21);

    vis2 = document.createElement('div');
    vis2.className = 'col-lg-8';
    vis2.id = 'vis2';
    vis2.style="width:70%;height:70%;max-height:220px";
    row2.appendChild(vis2);


    page.appendChild(row2);

    // next button
    row3 = document.createElement('div');
    row3.className = 'row';

    btn1 = document.createElement('button');
    btn1.className = 'col-lg-3 col-md-3 col-sm-3 col-xs-3 btn btn-success btn_next';
    btn1.addEventListener('click',print_graph2);
    btn1.innerHTML = 'הבא';


    row3.appendChild(btn1);

    col32 = document.createElement('div');
    col32.className = 'col-lg-9';
    row3.appendChild(col32);

    page.appendChild(row3);


    // ajax for chart 1
    var xhr;
    xhr = new XMLHttpRequest();
    xhr.abort();
    xhr.open("GET","../print_data.php?action=pie_new_lead",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200)&&(xhr.readyState==4))
        {
            next(xhr.response)
        }
        function next (new_leads_amount)
        {
            var xhr2;
            xhr2 = new XMLHttpRequest();
            xhr2.abort();
            xhr2.open("GET","../print_data.php?action=pie_arch_lead",true);
            xhr2.onreadystatechange=function()
            {
                if ((xhr2.status == 200) && (xhr2.readyState == 4))
                {
                    google.charts.setOnLoadCallback(drawChart1(new_leads_amount, xhr2.response));
                }
            }
            xhr2.send(null);
        }
    };
    xhr.send(null);

    // ajax for chart 2 - total leads last month
    var xhr3;
    xhr3 = new XMLHttpRequest();
    xhr3.abort();
    xhr3.open("GET","../print_data.php?action=pie_total_amount_month_lead",true);
    xhr3.onreadystatechange=function()
    {
        if ((xhr3.status == 200) && (xhr3.readyState == 4))
        {
            next2(xhr3.response)
        }

    }
    xhr3.send(null);

    // ajax for chart 2 - total leads 2 months ago
    function next2(month1)
    {
        var xhr4;
        xhr4 = new XMLHttpRequest();
        xhr4.abort();
        xhr4.open("GET","../print_data.php?action=pie_total_amount_month2_lead",true);
        xhr4.onreadystatechange=function()
        {
            if ((xhr3.status == 200) && (xhr3.readyState == 4))
            {
                next3(month1,xhr4.response)
            }

        }
        xhr4.send(null);
    }
    // ajax for chart 2 - total leads 3 months ago
    function next3(month1,month2)
    {
        var xhr5;
        xhr5 = new XMLHttpRequest();
        xhr5.abort();
        xhr5.open("GET","../print_data.php?action=pie_total_amount_month3_lead",true);
        xhr5.onreadystatechange=function()
        {
            if ((xhr5.status == 200) && (xhr5.readyState == 4))
            {
                drawChart2(month1,month2,xhr5.response);
            }
        }
        xhr5.send(null);
    }

    // drawing chart1 1
    function drawChart1(new_leads_amount,archived_leads_amount)
    {

        var data1 = google.visualization.arrayToDataTable([
            ["New Leads", "Archived Leads"],
            ["New Leads", parseInt(new_leads_amount)],
            ["Archived Leads", parseInt(archived_leads_amount)]]);

        var options1 =
            {
                title: "Leads Status Segmentation",
                width: '100%',
                height: '100%',
                colors: ["blue", "red"],
                is3D: true
            };
        var chart1 = new google.visualization.PieChart(document.getElementById("vis1"));
        chart1.draw(data1, options1);
    }
    function drawChart2(month1,month2,month3)
    {
        var data2 = google.visualization.arrayToDataTable([
            ['Period', 'Leads Amount', { role: 'style' }],
            ['Last Month', parseInt(month1), 'gold'],            // RGB value
            ['1 M - 2 M', parseInt(month2), 'silver'],            // English color name
            ['2 M - 3 M', parseInt(month3), 'gold']]);

        var options2 =
            {
                title: "Leads Creation Segmentation",
                width: '100%',
                height: '100%',
                is3D: true
            };
        var chart2 = new google.visualization.BarChart(document.getElementById("vis2"));
        chart2.draw(data2, options2);
    }
}


// print graph for orders
function print_graph2()
{
    var page = document.getElementById('page');
    page.innerHTML='';

// Draw Graph total income in 3 months

    row1 = document.createElement('div');
    row1.className = 'row';

    col11 = document.createElement('div');
    col11.className = 'col-lg-2';
    row1.appendChild(col11);

    vis1 = document.createElement('div');
    vis1.className = 'col-lg-8';
    vis1.id = 'vis1';
    vis1.style="width:100%;height:76%;max-height:470px";
    row1.appendChild(vis1);
    page.appendChild(row1);


    // ajax for chart 1 - total income orders month1
    var xhr;
    xhr = new XMLHttpRequest();
    xhr.abort();
    xhr.open("GET","../print_data.php?action=pie_income_orders_month1",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status == 200) && (xhr.readyState == 4))
        {
            next2(xhr.response);
        }

    }
    xhr.send(null);

    // ajax for chart 1 - total income orders month2
    function next2(month1)
    {
        var xhr2;
        xhr2 = new XMLHttpRequest();
        xhr2.abort();
        xhr2.open("GET","../print_data.php?action=pie_income_orders_month2",true);
        xhr2.onreadystatechange=function()
        {
            if ((xhr2.status == 200) && (xhr2.readyState == 4))
            {
                next3(month1,xhr2.response)
            }

        }
        xhr2.send(null);
    }
    // ajax for chart 2 - total leads 3 months ago
    function next3(month1,month2)
    {
        var xhr3;
        xhr3 = new XMLHttpRequest();
        xhr3.abort();
        xhr3.open("GET","../print_data.php?action=pie_income_orders_month3",true);
        xhr3.onreadystatechange=function()
        {
            if ((xhr3.status == 200) && (xhr3.readyState == 4))
            {
                drawChart(month1,month2,xhr3.response);
            }
        }
        xhr3.send(null);
    }

    // drawing chart
    function drawChart(month1,month2,month3)
    {
        var data = google.visualization.arrayToDataTable([
            ['Period', 'Total Sales in ILS', { role: 'style' }],
            ['Last Month', parseInt(month1), 'gold'],            // RGB value
            ['1 M - 2 M', parseInt(month2), 'silver'],            // English color name
            ['2 M - 3 M', parseInt(month3), 'gold']]);

        var options =
            {
                title: "Total Sales Segmentation",
                width: '100%',
                height: '100%',
                is3D: true
            };
        var chart = new google.visualization.BarChart(document.getElementById("vis1"));
        chart.draw(data, options);
    }
}

function display_orders()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=order_details",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200) && (xhr.readyState==4))
        {
            child.innerHTML = xhr.response;
        }
    };
    page.appendChild(child);
    xhr.send(null);
}
//display additional details for order
function display_orders_more(orderNumber)
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=order_details_more&orderNumber="+orderNumber,true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200) && (xhr.readyState==4))
        {
            child.innerHTML = xhr.response;
        }
    };
    page.appendChild(child);
    xhr.send(null);
}
// display archived order details
function display_orders_archive()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=arch_order",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status==200) && (xhr.readyState==4))
        {
            child.innerHTML = xhr.response;
        }
    };
    page.appendChild(child);
    xhr.send(null);
}
// next page display in print archive order
function next_print_arch_order()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=arch_order_next",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status == 200) && (xhr.readyState == 4))
        {
            child.innerHTML = xhr.response;
        }
    };
    page.appendChild(child);
    xhr.send(null);
}
function prev_print_arch_order()
{
    var page = document.getElementById('page');
    page.innerHTML='';
    child = document.createElement('div');
    //ajax
    var xhr;
    xhr = new XMLHttpRequest();

    xhr.abort();
    xhr.open("GET","../print_data.php?action=arch_order_prev",true);
    xhr.onreadystatechange=function()
    {
        if ((xhr.status == 200) && (xhr.readyState == 4))
        {
            //console.log(xhr.response);
            child.innerHTML = xhr.response;
        }
    };
    page.appendChild(child);
    xhr.send(null);
}
