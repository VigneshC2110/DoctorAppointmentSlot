<div class="form1">
    <h2 style="text-align:center;">Book an Appointment</h2>
    <form method="POST" action="appointment.php">
        <label for="patient_name">Patient Name:</label>
        <input type="text" id="patient_name" name="patient_name" required>

        <label for="reason">Reason for Visit:</label>
        <input type="text" id="reason" name="reason" required>

        <label for="slot_time">Slot Time :</label>
        <input type="time" id="slot_time" name="slot_time" required>

        <button type="submit" name="action" value="add">Book Slot</button>
    </form>
</div>
