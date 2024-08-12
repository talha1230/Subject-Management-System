<?php include('admin/includes/dbconnection.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>UNIMY Subject Management System</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body style="background: #F0F2F5;">
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">UNIMY Subject Management System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Custom Header -->
        <header class="py-5" style="background: linear-gradient(98deg, #925FE2 0%, #DFCFF7 100%); color: white; position: relative; overflow: hidden; box-shadow: 12px 12px 48px 24px rgba(0, 0, 0, 0.12); border-radius: 24px; margin: 16px;">
            <div class="container position-relative">
                <div class="text-center">
                    <h1 class="fw-bolder">UNIMY Subject Management System</h1>
                    <p style="color: rgba(255, 255, 255, 0.75);">6 August, 2024</p>
                </div>
                <!-- Decorative Images -->
                <img src="https://via.placeholder.com/183x183" alt="Backpack" style="position: absolute; top: 60px; right: 16px; width: 183px; transform: rotate(8.84deg);" />
                <img src="https://via.placeholder.com/326x326" alt="Scholar Cap" style="position: absolute; top: 83px; right: 200px; width: 326px; transform: rotate(-28.13deg);" />
            </div>
        </header>

        <!-- Page content-->
        <div class="container">
            <div class="row justify-content-center">
                <!-- Search Widget-->
                <div class="col-lg-8">
                    <div class="card mb-4" style="box-shadow: 8px 8px 48px 8px rgba(0, 0, 0, 0.08); border-radius: 24px;">
                        <div class="card-header text-center" style="background-color: white; padding: 20px 0;">
                            <h5 class="card-title" style="color: rgba(0, 0, 0, 0.5);">Search teacher by name or emp id</h5>
                        </div>
                        <form method="post" class="card-body d-flex justify-content-center align-items-center">
                            <input class="form-control me-2" type="text" placeholder="Enter search term..." name="searchdata" style="border-radius: 24px; width: 60%;" />
                            <button class="btn btn-primary" name="search" type="submit" style="background: #925FE2; border-radius: 25px;">Go!</button>
                        </form>
                    </div>
                </div>

                <!-- Search Results -->
                <?php if(isset($_POST['search'])) { 
                    $sdata=$_POST['searchdata']; ?>
                    <div class="col-lg-10">
                        <div class="card mb-4" style="box-shadow: 8px 8px 48px 8px rgba(0, 0, 0, 0.08); border-radius: 24px;">
                            <div class="card-header text-center">
                                <h4 class="fw-bolder">Result against "<?php echo $sdata;?>" keyword</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Employee Name</th>
                                            <th>Course Name</th>
                                            <th>Subject Name</th>
                                            <th>Allocation Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql="SELECT tblsuballocation.ID as suballid,tblsuballocation.CourseID,tblsuballocation.Teacherempid,tblsuballocation.Subid,tblsuballocation.AllocationDate,tblteacher.EmpID,tblteacher.FirstName,tblteacher.LastName,tblcourse.BranchName,tblcourse.CourseName,tblsubject.ID,tblsubject.CourseID,tblsubject.SubjectFullname,tblsubject.SubjectShortname,tblsubject.SubjectCode from tblsuballocation join tblteacher on tblteacher.EmpID=tblsuballocation.Teacherempid join tblcourse on tblcourse.ID=tblsuballocation.CourseID join tblsubject on tblsubject.ID=tblsuballocation.Subid where tblsuballocation.Teacherempid like '%$sdata%' || tblteacher.FirstName like '%$sdata%'";
                                        $query = $dbh -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt);?></td>
                                                    <td><?php echo htmlentities($row->FirstName);?> <?php echo htmlentities($row->LastName);?>(<?php echo htmlentities($row->Teacherempid);?>)</td>
                                                    <td><?php echo htmlentities($row->BranchName);?>(<?php echo htmlentities($row->CourseName);?>)</td>
                                                    <td><?php echo htmlentities($row->SubjectFullname);?>(<?php echo htmlentities($row->SubjectCode);?>)</td>
                                                    <td><?php echo htmlentities($row->AllocationDate);?></td>
                                                </tr>
                                                <?php 
                                                $cnt++;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No record found against this search</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-4 bg-dark text-white-50">
            <div class="container text-center">
                <small>&copy; UNIMY Subject Management System</small>
            </div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
