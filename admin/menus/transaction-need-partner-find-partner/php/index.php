<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <?php include "../../template/metas.php"; ?>

    <!-- Title Page-->
    <title>Find Partner</title>

    <!-- Styles -->
    <?php include "../../template/styles.php"; ?>

    <link rel="stylesheet" href="../css/pagination.css">
</head>

<body class="animsition">
    <div class="page-wrapper" style="overflow-y: hidden;">
        <!-- Sidebar -->
        <?php include "../../template/navbar.php"; ?>

        <div class="page-container">
            <!-- Header -->
            <?php include "../../template/header.php"; ?>

            <!-- Content-->
            <div class="main-content">
                <script>
                    let searchData = '';
                    let sortData = '';
                    let filterData = '';
                    let dateData = '';
                </script>

                <div class = "developer-original-pagination-container">
                    <?php 
                        $transactionID = "&TransactionID=" . $_GET['TransactionID']; echo "<script>let transactionID = '&TransactionID=" . $_GET['TransactionID'] . "';</script>";
                        $transactionPage = "&TransactionPage=" . $_GET['TransactionPage']; echo "<script>let transactionPage = '&TransactionPage=" . $_GET['TransactionPage'] . "';</script>";
                        $transactionProduct = "&TransactionProduct=" . $_GET['TransactionProduct']; echo "<script>let transactionProduct = '&TransactionProduct=" . $_GET['TransactionProduct'] . "';</script>";
                    ?>
                    <abbr title="Refresh Page"><a href = "index.php?page=1<?= $transactionID . $transactionPage . $transactionProduct ?>"><button class = "refresh">&#8635;</button></a></abbr>
                    
                    <?php
                        // Configure your application here ------------------------------------------------------
                        // Database
                        $table = "tbl_partners";
                        $autostructure = true; // Matikan jika ingin custom struktur table
                        $tablehead = ['ID', 'Username', 'Email', 'PhoneNumber', 'Status', 'Province', 'District', 'Subdistrict'];
                        $tablebody = ['ID', 'Username', 'Email', 'PhoneNumber', 'Status', 'Province', 'District', 'Subdistrict'];
                        $searchfor = ['ID', 'Username', 'Email', 'PhoneNumber', 'Status', 'Province', 'District', 'Subdistrict'];
                        $exportcolumn = "ID, Username, Password, Email, PhoneNumber, Status, StatusApproval";

                        // Pages (Add, Edit, Delete)
                        $crud = "form.php"; echo "<script>let crud = '$crud';</script>";
                        $url = "index.php?"; echo "<script>let pageURL = '$url';</script>";

                        // Features -------------------------------
                        // Filter
                        $filterfeature = true;
                        $filterfeaturefor = "Status";
                        $filterfeaturevalue = ['Dapat melayani', 'Sedang tidak dapat melayani'];

                        // Sort
                        $sortfeature = false;
                        $sortfeaturevalue = ['ID', 'Username', 'Password', 'Level', 'Price', 'Date'];

                        // Date Search
                        $datesearchfeature = false;
                        $datecolumn = "Date";

                        // Button Show Image in Table
                        $image = true;
                        $imagecolumn = "Image";

                        // Session (Activate if there is login)
                        $session = false;

                        // Total Price
                        $totalpricefeature = false;
                        $totalpricecolumn = "Price";

                        // Export to Excel button
                        $exportexcelfeature = false;

                        // Others
                        $configuration = 5; // How many datas in the table
                        $center = 2; // How many pagination boxes

                        if(!isset($_GET['page'])&&!isset($_GET['null'])){ header("location: " . $url . "page=1"); }

                        $search = null;
                        $searchvalue = null;
                        $sort = null;
                        $sortvalue = null;
                        $sortby = null;
                        $filter = null;
                        $filtervalue = null;
                        $datevalue = null;
                        $datesearchpast = null;
                        $datesearchpresent = null;
                        $syntax = null;
                        $exportdatabase = null;
                        $die = 0;
                        $page = $_GET['page']; echo "<script>let page = '$page';</script>";

                        if(!is_numeric($page)){echo "<script>window.location.href='" . $url . "page=1';</script>";}

                        if(isset($_GET['search']))
                        {
                            $search = $_GET['search'];
                            $searchvalue = "&search=$search";
                            $syntax = "WHERE (";
                            
                            for($i=0; $i<count($searchfor); $i++)
                            {
                                if($i==0||$i==count($searchfor)){$syntax = $syntax . $searchfor[$i] . " LIKE '%$search%'";}
                                else if($i>0){$syntax = $syntax . " OR " . $searchfor[$i] . " LIKE '%$search%'";}
                            }

                            $syntax = $syntax . ")";

                            echo "
                            <script>
                                document.addEventListener('DOMContentLoaded', ()=>{
                                    let search = document.getElementById('searchfordata');
                                    searchData = '&search=$search';
                                    search.value = '$search';
                                });
                            </script>";
                        }
                        
                        if(isset($_GET['filter']))
                        {
                            $filter = $_GET['filter'];
                            $filtervalue = "&filter=$filter";
                            $syntax = "WHERE ($filterfeaturefor = '$filter')";

                            echo "<script>filterData = '&filter=$filter';</script>";
                        }

                        if(isset($_GET['past']) && isset($_GET['present']))
                        {
                            $datesearchpast = $_GET['past'];
                            $datesearchpresent = $_GET['present'];
                            $datevalue = "&past=$datesearchpast&present=$datesearchpresent";

                            if(str_contains($syntax, "WHERE"))
                            {
                                $syntax = $syntax . " AND ($datecolumn BETWEEN '$datesearchpast' AND '$datesearchpresent')";
                            }
                            else
                            {
                                $syntax = $syntax . " WHERE ($datecolumn BETWEEN '$datesearchpast' AND '$datesearchpresent')";
                            }

                            echo "<script>dateData = '&past=$datesearchpast&present=$datesearchpresent';</script>";
                        }

                        if(isset($_GET['sort']))
                        {
                            $sort = $_GET['sort'];
                            $sortby = $_GET['by'];
                            $sortvalue = "&sort=$sort&by=$sortby";
                            $syntax = $syntax . " ORDER BY $sort $sortby";

                            echo "<script>sortData = '&sort=$sort&by=$sortby';</script>";
                        }

                        if($die == 0){
                        $database = mysqli_query($conn, "SELECT * FROM $table $syntax");
                        $exportdatabase = "SELECT * FROM $table $syntax";
                        $no = 0;
                        $noA = 0;
                        $noB = $configuration;
                        $noC = $center + $center + 1;
                        $noD = $center + $center;
                        $noE = $configuration;
                        $noF = $configuration;
                        $box = $configuration;
                        $total = 0;
                        $minimum = $page - $center;
                        $maximum = $page + $center;
                        $minimumdata = $page * $box;
                        $maximumdata = $minimumdata + $box;

                        $datas = [];
                        $active = null;
                        $totalamount = 0;

                        while($data = mysqli_fetch_array($database))
                        {
                            $noA++; $noF++;
                            if($noA==$noB){$noB+=$box; $total++;}

                            if($noF>=$minimumdata&&$noF<=$maximumdata){$datas[$noA] = $data;}

                            if($totalpricefeature == true)
                            {
                                $amount = str_replace(['Rp', '.'], '', $data[$totalpricecolumn]);
                                $totalamount += $amount;
                            }
                        }

                        $noF = $noB - $noA; if($noF < $configuration){$total++;}

                        if($page>$total && $total!=0){echo "<script>window.location.href='" . $url . "page=$total';</script>";}
                        if($page<1 && $noA != 0){echo "<script>window.location.href='" . $url . "page=1';</script>";}

                        for($i = 1; $i<$center + 1; $i++){$noC--; if($page==$i){$maximum=$page+$noC;}}
                        for($i = 0; $i<$center; $i++){if($total-$i==$page){$minimum=$total-$noD;}}
                        
                        if($minimum<2){$minimum=1;}
                        if($maximum>$total){$maximum=$total;}

                        $prev = $page - 1;
                        $next = $page + 1;

                        if($prev<1){$prev=1;}
                        if($next>$total){$next=$total;}

                        $prev = "page=" . $prev;
                        $next = "page=" . $next;
                    ?>
                    <div class = "content">
                        <div class = "buttons">
                            <a href="../../transaction-need-partner/php/index.php?page=<?= $_GET['TransactionPage'] ?>"><input type = "button" value = "Return"></a>
                            
                            <div class = "systems" id = "SystemsButtons">
                                <?php
                                    if($datesearchfeature == true){ ?>
                                        <span class = "systemgroup">
                                            <input type = "date" value="<?= $datevalue ? $datesearchpast : ''?>">
                                            <input type = "date" value="<?= $datevalue ? $datesearchpresent : ''?>">
                                            <input type = "button" value = "Search" id = "SearchForDate">
                                        </span>
                                    <?php }

                                    if($filterfeature == true){ ?>
                                        <select id = "FilterSelect">
                                            <option value = "null">Filter <?= $filterfeaturefor ?> by</option>
                                            <?php 
                                                for($i=0; $i<count($filterfeaturevalue); $i++)
                                                {
                                                    $selected = $filterfeaturevalue[$i] == $filter ? 'selected' : '';
                                                    echo "<option value = '" . $filterfeaturevalue[$i] . "'" . $selected . ">" . $filterfeaturevalue[$i] . "</option>";
                                                }

                                            ?>
                                        </select>
                                    <?php }

                                    if($sortfeature == true){ ?>
                                        <span class = "systemgroup sort">
                                            <select id = "SortSelect">
                                                <option value = "null">Sort by</option>
                                                <?php 
                                                    for($i=0; $i<count($sortfeaturevalue); $i++)
                                                    {
                                                        $selected = $sortfeaturevalue[$i] == $sort ? 'selected' : '';
                                                        echo "<option value = '" . $sortfeaturevalue[$i] . "'" . $selected . ">" . $sortfeaturevalue[$i] . "</option>";
                                                    }

                                                ?>
                                            </select>
                                            <select>
                                                <option value = "ASC" <?= $sortby == "ASC" ? 'selected' : '' ?>>Ascending</option>
                                                <option value = "DESC" <?= $sortby == "DESC" ? 'selected' : '' ?>>Descending</option>
                                            </select>
                                        </span>
                                    <?php }
                                ?>
                                <input type = "button" value = "Options" class = "buttonshowsystems">
                                <input type = "text" maxlength = "20" placeholder="Cari Data" id = "searchfordata" class="search">
                            </div>
                        </div>

                        <div class = "table">
                            <div>
                                <table style="border-radius:8px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>

                                            <?php
                                                if($autostructure == true){
                                                    for($i=0; $i<count($tablehead); $i++)
                                                    {
                                                        echo "<th>" . $tablehead[$i] . "</th>";
                                                    }
                                                }

                                                // Edit didalam tag php jika ada tambahan -------------------------------------
                                                ?> 
                                                    <th>Skill</th>
                                                <?php
                                            ?>

                                            <?= $image == true ? "<th>Gambar</th>" : "" ?>
                                            <?php 
                                                if($session == true)
                                                {
                                                    if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)
                                                    {
                                                        echo "<th>Actions</th>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<th>Actions</th>";
                                                }
                                            ?>
                                        </tr>
                                    </thead>

                                    <?php
                                        if($noA > 0){
                                        for($i = 0; $i < $noA; $i++)
                                        { $no++; $noE++; if($noE<=$minimumdata){continue;} if($noE>$maximumdata){break;}
                                    ?>

                                    <tbody>
                                        <tr <?php if($no % 2 == 0){echo "style='background:rgb(245, 245, 245);'";} ?>>
                                            <td><?= $no ?></td>

                                            <?php
                                                if($autostructure == true){
                                                    for($ii=0; $ii<count($tablebody); $ii++)
                                                    {
                                                        echo "<td>" . $datas[$no][$tablebody[$ii]] . "</td>";
                                                    }
                                                }

                                                // Edit didalam tag php jika ada tambahan -------------------------------------
                                                ?> 
                                                    <td><span><a href="<?= 'skill.php?PartnerEmail=' . $datas[$no]['Email'] . '&page=' . $page . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>"><button class = 'button-show'>Show</button></a></td>
                                                    <?= $image == true ? "<td><span><button class = 'button-show image' data-image= '" . $datas[$no][$imagecolumn] . "'>Show</button></span></td>" : "" ?>
                                                    <td><span><a href="<?= 'form.php?edit&id=' . $datas[$no]['ID'] . '&page=' . $page . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>"><button class = 'button-show'>Detail</button></a><a href="<?= 'form.php?edit&id=' . $datas[$no]['ID'] . '&page=' . $page . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct . "&auto-select-partner-is-on-process" ?>"><button class = 'button-show'>Pilih</button></a></td>
                                        </tr>
                                    </tbody>

                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        
                        <?php if($totalpricefeature == true || $exportexcelfeature == true){ ?>
                            <div class="otherFeatures">
                                <div>
                                    <?php if($totalpricefeature == true) { ?>
                                        <span class="amount" style="width:49%;">Total Amount : <?= 'Rp.' . number_format($totalamount, 0, ',', '.'); ?></span>
                                    <?php } if($exportexcelfeature == true) { ?>
                                        <span class="excel" <?= $totalpricefeature == true ? 'style="width:49%;"' : 'style="width:100%;"'?>>
                                            <form action="excel.php?excel" method="post">
                                                <input type="text" name="TableName" value="<?= $table ?>">
                                                <input type="text" name="TableColumns" value="<?= $exportcolumn ?>">
                                                <input type="text" name="Database" value="<?= $exportdatabase ?>">
                                                <button>Export Excel</button>
                                            </form>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class = "pagination" id = "pagination">
                        <div>
                            <abbr title = "Ke halaman pertama"><a href = "<?= $url . "page=1" . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>#pagination"><button class="paginator">|&laquo;</button></a></abbr>
                            <abbr title = "Ke halaman sebelumnya"><a href = "<?= $url . $prev . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>#pagination"><button class="paginator">&laquo;</button></a></abbr>

                            <?php
                                for($i = $minimum; $i <= $maximum; $i++)
                                {
                                    if($i == $page){$active = "active";}
                                    if($i != $page){$active = "";}
                            ?>
                                    <a href = "<?= $url . "page=" . $i . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>#pagination"><button class="<?= $active ?>"><?= $i ?></button></a>
                            <?php } ?>

                            <abbr title = "Ke halaman selanjutnya"><a href = "<?= $url . $next . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>#pagination"><button class="paginator">&raquo;</button></a></abbr>
                            <abbr title = "Ke halaman terakhir"><a href = "<?= $url . "page=" . $total . $searchvalue . $sortvalue . $filtervalue . $datevalue . $transactionID . $transactionPage . $transactionProduct ?>#pagination"><button class="paginator">&raquo;|</button></a></abbr>
                        </div>
                    </div>
                </div>

                <?php 
                    if($no==0){echo "<script>window.location.href='" . $url . "page=1&search=$search&null';</script>";}}
                    else{ echo "<tbody><tr id = 'no-data-tr'><td colspan = '0'>Tidak ada data</td></tr></tbody></table></div></div></div></div>"; }}
                ?>

                <div class="developer-original-blackbarrier hidden"></div>

                <div class="developer-original-modal-delete hidden">
                    <p>Yakin ingin menghapus data ini?</p>
                    <div>
                        <button>Tidak</button>
                        <button>Iya</button>
                    </div>
                </div>

                <div class="developer-original-modal-image hidden">
                    <img>
                </div>

                <div class="developer-original-modal-no-image hidden">
                    <p>Data tidak memiliki gambar</p>
                    <button>Oke😢</button>
                </div>

                <div class="developer-original-modal-systems hidden">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <?php include "../../template/javascipts.php"; ?>
    <script src = "../javascript/pagination.js"></script>
</body>

</html>