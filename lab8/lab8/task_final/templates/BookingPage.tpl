<!DOCTYPE html>
<html lang="">
{HEAD}

<body>
    {HEADER}

    <!-- ////////////////////////////////////////////////////////// -->

    <article class="BookingArea">

        <div class="Images">
            <img class="FirstIm" src="../Images/LeftImage.png" alt="">
            <img class="SecondIm" src="../Images/RightImage.png" alt="">
        </div>

        <div class="BookZone">
            <p class="SectorName">
                <b>{LABEL="motto"}</b>
            </p>
            <img class="decor2" src="../Images/GoldThing.png" alt="">
            <p class="Review">
                {LABEL="review"}
            </p>
            <!-- ///////////////// -->
			<!--onsubmit="alert('Success!')" -->
            <form class = "buttons" method="post" action="../scripts/Order.php">
                <div class ="Name">
                    <label class="Label" for="NameI">Name</label> 
                    <input value="{NAME}" class="Input" type="text" required name="name" id="NameI" placeholder="  your name *" style="padding: 2px 1px; border: 2px solid #c9a131">
                </div>
                <div class="Email">
                    <label class="Label" for="EmailI">Email</label> 
                    <input value="{EMAIL}" class="Input" type="email"required name="email" id="EmailI" placeholder="  your email *">
               </div>
               <div class="Date">
                    <label class="Label" for="DateI">Date</label> 
                    <input type="text" class="Input" required name="date" placeholder="  date *" id="DateI" onfocus="(this.type='date')"/>
                    <!-- <input class="InputDate" type="date" name="date" id="DateI" placeholder="date *"> -->
               </div>
                <div class="Number">
                    <label class="Label">Table number</label>
                    <select class="Input" name="table" required id="Number">
                        <option value="" disabled selected>&nbsp&nbsptable number</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="button">
                    <button class="InputButton" type="submit">{LABEL="book"}</button>
                </div>
            </form>
            <!-- ///////////////////// -->
        </div>

    </article>

    <!-- ////////////////////////////////////////////////////////// -->
    {FOOTER}
</body>