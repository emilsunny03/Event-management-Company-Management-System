<?php
require('connection.php');
session_start();

$email = $_SESSION['email'];

// Fetch notes for the logged-in company
$sql = "SELECT note_date, note_text FROM calendar_notes WHERE company_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$notes = [];
while ($row = $result->fetch_assoc()) {
    $notes[$row['note_date']] = $row['note_text'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .calendar-container {
            margin-top: 20px;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .day {
            width: 100%;
            height: 100px;
            background: #e0e7ff;
            border-radius: 10px;
            text-align: center;
            line-height: 2;
            position: relative;
            cursor: pointer;
        }
        .day:hover {
            background: #d6dbff;
        }
        .note-badge {
            background: #ff7c7c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: inline-block;
            position: absolute;
            top: 5px;
            right: 10px;
            text-align: center;
            line-height: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="calendar-container">
        <div class="calendar-header">
            <button class="btn btn-dark" id="prevMonthBtn"><</button>
            <h2 id="monthYear"></h2>
            <button class="btn btn-dark" id="nextMonthBtn">></button>
        </div>
        <div class="calendar" id="calendar"></div>
    </div>
</div>

<!-- Modal for Adding Notes -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="noteForm" method="POST" action="save_note.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="noteDate" name="note_date">
                    <input type="hidden" id="companyEmail" name="company_email" value="<?= htmlspecialchars($email) ?>">
                    <div class="mb-3">
                        <label for="noteText" class="form-label">Note:</label>
                        <textarea class="form-control" id="noteText" name="note_text" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const calendarEl = document.getElementById('calendar');
    const monthYearEl = document.getElementById('monthYear');
    const prevMonthBtn = document.getElementById('prevMonthBtn');
    const nextMonthBtn = document.getElementById('nextMonthBtn');
    const noteModal = new bootstrap.Modal(document.getElementById('noteModal'), {});
    const noteDateEl = document.getElementById('noteDate');
    const noteTextEl = document.getElementById('noteText');

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    const notes = <?php echo json_encode($notes); ?>;

    function renderCalendar(month, year) {
        calendarEl.innerHTML = '';
        monthYearEl.textContent = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });

        const firstDay = new Date(year, month).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            calendarEl.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            dayCell.classList.add('day');
            dayCell.textContent = day;

            const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            
            if (notes[formattedDate]) {
                const noteBadge = document.createElement('span');
                noteBadge.classList.add('note-badge');
                noteBadge.textContent = '!';
                dayCell.appendChild(noteBadge);
            }

            dayCell.onclick = () => openNoteModal(formattedDate, notes[formattedDate]);
            calendarEl.appendChild(dayCell);
        }
    }

    function openNoteModal(date, note = '') {
        noteDateEl.value = date;
        noteTextEl.value = note;
        noteModal.show();
    }

    prevMonthBtn.onclick = () => {
        currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        currentYear = currentMonth === 11 ? currentYear - 1 : currentYear;
        renderCalendar(currentMonth, currentYear);
    };

    nextMonthBtn.onclick = () => {
        currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
        currentYear = currentMonth === 0 ? currentYear + 1 : currentYear;
        renderCalendar(currentMonth, currentYear);
    };

    renderCalendar(currentMonth, currentYear);
</script>
</body>
</html>
