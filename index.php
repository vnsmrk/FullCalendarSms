<?php require_once('db-connect.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <style>
    :root {
    --bs-success-rgb: 71, 222, 152 !important;
}

html, body {
    height: 100%;
    width: 100%;
    font-family: Tahoma;
    overflow-x: hidden;
}

.btn-info.text-light:hover, .btn-info.text-light:focus {
    background: #000;
}

table, tbody, td, tfoot, th, thead, tr {
    border-color: #ededed !important;
    border-style: solid;
    border-width: 1px !important;
}

.calendar-container {
    padding: 30px; 
    background-color: #fff; 
    border-radius: 15px; /* Rounds the corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a drop shadow */
    margin: 0 auto; /* Center the container horizontally */
    overflow-x: auto;
}

.calendar-container:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

.fc-prev-button, .fc-next-button {
    background: none;
    border: none;
    color: green;
    text-decoration: underline;
    cursor: pointer;
    font-size: 1em;
    margin: auto;
}

.fc, .fc .fc-daygrid-day, .fc .fc-daygrid-day-top, .fc .fc-daygrid-day-number {
    color: black;
}

.fc-event, .fc-event-dot, .fc-daygrid-event, .fc-event-title, .fc-timegrid-event {
    color: green;
}

.fc .fc-col-header-cell {
    text-align: left;
    color: black;
}

.fc-daygrid .fc-col-header-cell-cushion {
    text-align: left;
    color: black;
}

.fc-daygrid-day-number {
    float: left; 
    margin-left: 5px;
    color: black;
}

.fc-daygrid-day-frame {
    text-align: left;
    vertical-align: top;
    padding: 5px;
}

.fc-daygrid-day {
    padding: 10px;
}

.fc-prev-button, .fc-next-button {
    color: green !important;
}

.modal-content {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    background-color: #53825c; 
    color: white;
    border-bottom: 1px solid #28a745;
}

.modal-title {
    color: white;
}

.btn-close {
    filter: brightness(0) invert(1);
}

.modal-footer .btn-primary {
    background-color: #53825c;
    border-color: #28a745;
}

.modal-footer .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.modal-footer .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.modal-content {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

#new-event {
    border-radius: 8px;
}

.event-container {
    max-height: 200px;
    overflow-y: auto;
    position: relative;
    padding-right: 15px;
}

.event-container::-webkit-scrollbar {
    width: 0;
    height: 0;
}

.event-container .event:not(:first-child) {
    display: none;
}

.event-container.show-more .event {
    display: block;
}

.show-more-btn {
    cursor: pointer;
    color: green;
    text-decoration: underline;
}

.event {
    margin-bottom: 1rem;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    word-wrap: break-word;
    overflow: hidden;
}

.event h5 {
    color: green;
    font-weight: bold;
}

.event .date {
    font-weight: bold;
    color: black;
}

.event p {
    margin: 0;
}
    </style>
</head>
<body class="bg-light">
<div class="container py-5" id="page-container">
    <div class="row">
        <div class="col-md-12">
            <div class="calendar-container">
                <div class="col-md-12">
                    <div class="form-group mb-3 ">
                        <label for="schedule-list" class="control-label mb-4">Reminders</label>
                        <div id="schedule-list" class="border p-2 rounded event-container">
                            <?php
                            date_default_timezone_set('Asia/Manila');
                            $current_date = date('Y-m-d');
                            $formatted_date = date('l, d F Y');
                            $result = $conn->query("SELECT title, description, start_datetime FROM schedule_list WHERE DATE(start_datetime) = '$current_date'");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $title = htmlspecialchars($row['title']);
                                    $description = htmlspecialchars($row['description']);
                                    $start_datetime = date('l, d F Y', strtotime($row['start_datetime']));
                                    echo '<div class="event">';
                                    echo '<div class="date">'.$start_datetime.'</div>';
                                    echo '<h5>'.$title.'</h5>';
                                    echo '<p>'.$description.'</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No events scheduled for today.</p>';
                            }
                            ?>
                        </div>
                        <div id="show-more-btn" class="show-more-btn">Show More</div>
                    </div>
                    <button class="btn btn-success mt-4 mb-4" id="new-event" data-bs-toggle="modal" data-bs-target="#schedule-modal">New Event</button>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Schedule Modal -->
    <div class="modal fade" id="schedule-modal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel"> New Event </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="save_schedule.php" method="post" id="schedule-form">
                        <input type="hidden" name="id" value="">
                        <div class="form-group mb-2">
                            <label for="name" class="control-label">Name</label>
                            <select class="form-control form-control-sm rounded-0" name="name" id="name" required>
                                <?php
                                // Fetch clients for dropdown
                                $clients = [];
                                $result = $conn->query("SELECT name FROM accounts WHERE usertype = 'client'");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="'.htmlspecialchars($row['name']).'">'.htmlspecialchars($row['name']).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="control-label">Description</label>
                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="start_datetime" class="control-label">Date</label>
                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="schedule-form">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header ">
                    <h5 class="modal-title">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Name</dt>
                            <dd id="detail-name" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Title</dt>
                            <dd id="detail-title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="detail-description" class=""></dd>
                            <dt class="text-muted">Date</dt>
                            <dd id="detail-start" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $schedules = $conn->query("SELECT * FROM `schedule_list`");
    $sched_res = [];
    foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
        $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
        $sched_res[$row['id']] = $row;
    }
    ?>
    <?php 
    if(isset($conn)) $conn->close();
    ?>
</body>
<script>
    var scheds = <?php echo json_encode($sched_res); ?>;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            customButtons: {
                prev: {
                    text: '',
                    click: function() {
                        calendar.prev();
                        updatePrevNextButtons();
                    }
                },
                next: {
                    text: '',
                    click: function() {
                        calendar.next();
                        updatePrevNextButtons();
                    }
                }
            },
            events: Object.values(scheds).map(function(event) {
                return {
                    id: event.id,
                    title: event.title,
                    start: event.start_datetime
                };
            }),
            eventClick: function(info) {
                var id = info.event.id;
                var schedule = scheds[id];
                if (schedule) {
                    $('#detail-name').text(schedule.name);
                    $('#detail-title').text(schedule.title);
                    $('#detail-description').text(schedule.description);
                    $('#detail-start').text(schedule.sdate);
                    $('#edit').attr('data-id', id);
                    $('#delete').attr('data-id', id);
                    $('#event-details-modal').modal('show');
                }
            }
        });

        function updatePrevNextButtons() {
            var date = calendar.getDate();
            var prevMonth = new Date(date.getFullYear(), date.getMonth() - 1, 1);
            var nextMonth = new Date(date.getFullYear(), date.getMonth() + 1, 1);

            $('.fc-prev-button').text(prevMonth.toLocaleString('default', { month: 'long' }));
            $('.fc-next-button').text(nextMonth.toLocaleString('default', { month: 'long' }));

            $('.fc-prev-button, .fc-next-button').css({
                'color': 'green',
                'text-decoration': 'underline',
                'background': 'none',
                'border': 'none',
                'cursor': 'pointer',
                'font-size': '1em'
            });
        }

        calendar.render();
        updatePrevNextButtons();

        $('#edit').on('click', function() {
            var id = $(this).attr('data-id');
            var schedule = scheds[id];
            if (schedule) {
                $('#schedule-modal #scheduleModalLabel').text('Edit Schedule');
                $('#schedule-modal input[name="id"]').val(id);
                $('#schedule-modal select[name="name"]').val(schedule.name);
                $('#schedule-modal input[name="title"]').val(schedule.title);
                $('#schedule-modal textarea[name="description"]').val(schedule.description);
                $('#schedule-modal input[name="start_datetime"]').val(schedule.start_datetime.replace(' ', 'T'));
                $('#event-details-modal').modal('hide');
                $('#schedule-modal').modal('show');
            }
        });

        $('#delete').on('click', function() {
            var id = $(this).attr('data-id');
            if (confirm('Are you sure you want to delete this schedule?')) {
                $.ajax({
                    url: 'delete_schedule.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>

<script>
document.getElementById('show-more-btn').addEventListener('click', function() {
    var eventContainer = document.querySelector('.event-container');
    if (eventContainer.classList.contains('show-more')) {
        eventContainer.classList.remove('show-more');
        this.textContent = 'Show More';
    } else {
        eventContainer.classList.add('show-more');
        this.textContent = 'Show Less';
    }
});

    </script>
</html>
