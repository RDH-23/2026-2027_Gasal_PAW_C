<!-- 4.3.2 Langkah 9
<fieldset>
    <legend>Person Detail</legend>
    <form name="myForm" action="processData_form.php" method="POST">
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" size="31">
        </div>
        
        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" size="31">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="passwd" size="31">
        </div>

        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" rows="3" cols="22"></textarea>
        </div>	

        <div class="field">
            <label for="state">State</label>
            <select name="state">
                <option value="-1" selected>[choose your state]</option>
                <option value="1">Australian Capital Territory</option>
                <option value="2">Queensland</option>
                <option value="3">Victoria</option>
                <option value="4">New South Wales</option>
                <option value="5">Tasmania</option>
                <option value="6">South Australia</option>
                <option value="7">Western Australia</option>
                <option value="8">Nothern Territory</option>
            </select>
        </div>	
        <div class="field">
            <input type="hidden" name="country" value="Australia">
        </div>
        <div class="field">
            <label for="sex">Gender</label>
            <input type="radio" name="sex" value="male">Male
            <input type="radio" name="sex" value="female">Female
        </div>
        <div class="field">
            <label for="vegetarian">Vegetarian</label>
            <input type="checkbox" name="vegetarian">
        </div>
        <div class="field">
            <label>&nbsp;</label>
            <input type="submit" value="Submit" name="submit"><input type="reset" value="Reset" name="reset">
        </div>
    </form>
</fieldset>
-->



<!-- 4.3.2 Langkah 9 -->
<?php
// Mengambil kembali data input sebelumnya jika tersedia di $_POST (Sticky Form)
$val_surname    = isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : '';
$val_email      = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$val_passwd     = isset($_POST['passwd']) ? htmlspecialchars($_POST['passwd']) : '';
$val_address    = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
$val_state      = isset($_POST['state']) ? $_POST['state'] : '-1';
$val_sex        = isset($_POST['sex']) ? $_POST['sex'] : '';
$val_vegetarian = isset($_POST['vegetarian']) ? true : false;
?>

<fieldset>
    <legend>Person Detail</legend>
    <form name="myForm" action="processData_form.php" method="POST">
        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" size="31" value="<?php echo $val_surname; ?>">
        </div>
        
        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" size="31" value="<?php echo $val_email; ?>">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="passwd" size="31" value="<?php echo $val_passwd; ?>">
        </div>

        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" rows="3" cols="22"><?php echo $val_address; ?></textarea>
        </div>	

        <div class="field">
            <label for="state">State</label>
            <select name="state">
                <option value="-1" <?php if ($val_state == "-1") echo 'selected'; ?>>[choose your state]</option>
                <option value="1" <?php if ($val_state == "1") echo 'selected'; ?>>Australian Capital Territory</option>
                <option value="2" <?php if ($val_state == "2") echo 'selected'; ?>>Queensland</option>
                <option value="3" <?php if ($val_state == "3") echo 'selected'; ?>>Victoria</option>
                <option value="4" <?php if ($val_state == "4") echo 'selected'; ?>>New South Wales</option>
                <option value="5" <?php if ($val_state == "5") echo 'selected'; ?>>Tasmania</option>
                <option value="6" <?php if ($val_state == "6") echo 'selected'; ?>>South Australia</option>
                <option value="7" <?php if ($val_state == "7") echo 'selected'; ?>>Western Australia</option>
                <option value="8" <?php if ($val_state == "8") echo 'selected'; ?>>Nothern Territory</option>
            </select>
        </div>	
        <div class="field">
            <input type="hidden" name="country" value="Australia">
        </div>
        <div class="field">
            <label for="sex">Gender</label>
            <input type="radio" name="sex" value="male" <?php if ($val_sex == "male") echo 'checked'; ?>>Male
            <input type="radio" name="sex" value="female" <?php if ($val_sex == "female") echo 'checked'; ?>>Female
        </div>
        <div class="field">
            <label for="vegetarian">Vegetarian</label>
            <input type="checkbox" name="vegetarian" <?php if ($val_vegetarian) echo 'checked'; ?>>
        </div>
        <div class="field">
            <label>&nbsp;</label>
            <input type="submit" value="Submit" name="submit"><input type="reset" value="Reset" name="reset">
        </div>
    </form>
</fieldset>

