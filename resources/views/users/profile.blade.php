@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    <h5>You are logged in as {{$username}}!</h5>
                            <script>
                                //alert("You are logged in.");

                                function myTestButtonFunction() {
                                    alert("You clicked this button!");
                                }

                                function editItem( itemId ) {
                                    window.location = ('../items/'+itemId +'/edit');
                                }

                                function deleteItem( itemId ) {
                                    window.location = ('../items/'+itemId +'/delete');
                                }

                                function postItem( itemId ) {
                                    window.location = ('../items/'+itemId+'/post');
                                }

                            </script>
                    <hr>

                    <div class="panel-heading">
                        <h4>Item Owned</h4>
                    </div>

                    <div class="panel-body">

                        <?php
                            $db = new mysqli('localhost', 'root', 'admin', 'blog');
                            if($db->connect_errno > 0){
                                die('Unable to connect to database [' . $db->connect_error . ']');
                            }
                            $sql = "select * from items i where i.owner = '".$email."';";
                            $items_owned = $db->query($sql);
                            $index = 1;

                            while($row = $items_owned->fetch_assoc()){
                                echo $index."  <br />";
                                echo "Name:". $row['name']; echo"<br />";
                                echo "Description:" .$row['description'];echo"<br />";
                                echo "Available:". $row['available'];echo"<br /><br /><br />";

                                $index++;
                                $current_item_id = $row['itemid']; // this is for clicking events handle

                                echo "
                                <div class='form-group'>
                                    <div class='col-md-8 col-md-offset-4'>
                                        <button type='submit' class='btn btn-primary' onclick='editItem(".$current_item_id.")'>
                                        Edit
                                        </button>
                                        <button type='submit' class='btn btn-primary' onclick='deleteItem(".$current_item_id.")'>
                                        Delete
                                        </button>
                                        <button type='submit' class='btn btn-primary' onclick='postItem(".$current_item_id.")'>
                                        Post
                                        </button>
                                    </div>
                                </div>";
                            }
                            $items_owned->close();
                        ?>
                    </div>
                    <hr>

                    <div class="panel-heading">
                        <h4>Item Posted</h4>
                    </div>

                    <div class="panel-body">

                        <?php

                            $sql = "select p.title, p.location, p.created_at, i.name from posts p, items i where p.item = i.itemid AND i.owner = '".
							$email."';";
                            $posts = $db->query($sql);
                            $index = 1;

                            while($row = $posts->fetch_assoc()){
                                echo $index."  <br />";
                                echo "Item name:". $row['name']; echo"<br />";
                                echo "Post title:" .$row['title'];echo"<br />";
                                echo "Created at:" .$row['created_at'];echo"<br />";
                                echo "Pick up location:". $row['location'];echo"<br /><br /><br />";
                                $index++;
                                echo "
                                <div class='form-group'>
                                    <div class='col-md-8 col-md-offset-4'>
                                        <button type='submit' class='btn btn-primary'>
                                        Edit
                                        </button>
                                        <button type='submit' class='btn btn-primary'>
                                        Delete
                                        </button>
                                    </div>
                                </div>";
                            }
                            $posts->close();
						?>


                    </div>

                    <hr>


                    <div class="panel-heading">
                        <h4>Item Bid</h4>
                    </div>

                    <div class="panel-body">
                        <?php

                        $sql = "select b.post, b.points, b.updated_at, b.status from bids b where b.bidder = '".
                            $email."';";
                        $posts = $db->query($sql);
                        $index = 1;

                        while($row = $posts->fetch_assoc()){
                            echo $index."  <br />";
                            echo "Bid post:". $row['post']; echo"<br />";
                            echo "Bidding points:" .$row['points'];echo"<br />";
                            echo "Last Update:" .$row['update_at'];echo"<br />";
                            echo "Bid Status:". $row['status'];echo"<br /><br /><br />";
                            $index++;
                            echo "
                                <div class='form-group'>
                                    <div class='col-md-8 col-md-offset-4'>
                                        <button type='submit' class='btn btn-primary'>
                                        Update
                                        </button>
                                        <button type='submit' class='btn btn-primary'>
                                        Withdraw
                                        </button>
                                    </div>
                                </div>";
                        }
                        $posts->close();
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
