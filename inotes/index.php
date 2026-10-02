<?php

include "db.php";

$insert = false;
$update = false;
$delete = false;

/* =========================================
   DELETE NOTE
========================================= */

if (isset($_GET['delete'])) {

    $sno = intval($_GET['delete']);

    $sql = "DELETE FROM notes WHERE sno = $sno";

    if (mysqli_query($conn, $sql)) {
        $delete = true;
    }
}


/* =========================================
   INSERT / UPDATE
========================================= */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    /* =====================================
       UPDATE
    ===================================== */

    if (isset($_POST['snoEdit'])) {

        $sno = intval($_POST['snoEdit']);

        $title = mysqli_real_escape_string(
            $conn,
            $_POST['titleEdit']
        );

        $description = mysqli_real_escape_string(
            $conn,
            $_POST['descriptionEdit']
        );


        $sql = "UPDATE notes
                SET title = '$title',
                    description = '$description'
                WHERE sno = $sno";


        if (mysqli_query($conn, $sql)) {
            $update = true;
        }

    }


    /* =====================================
       INSERT
    ===================================== */

    else {

        $title = mysqli_real_escape_string(
            $conn,
            $_POST['title']
        );

        $description = mysqli_real_escape_string(
            $conn,
            $_POST['description']
        );


        $sql = "INSERT INTO notes
                (title, description)
                VALUES
                ('$title', '$description')";


        if (mysqli_query($conn, $sql)) {
            $insert = true;
        }

    }
}


/* =========================================
   GET NOTES
========================================= */

$sql = "SELECT * FROM notes ORDER BY sno DESC";

$result = mysqli_query($conn, $sql);

$totalNotes = mysqli_num_rows($result);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>iNotes | Smart Notes</title>


    <link rel="stylesheet"
          href="style.css">

</head>


<body>


<!-- =========================================
     BACKGROUND GRAPHICS
========================================= -->

<div class="background">

    <div class="glow glow-one"></div>

    <div class="glow glow-two"></div>

</div>



<!-- =========================================
     NAVBAR
========================================= -->

<nav class="navbar">


    <div class="logo">


        <div class="logo-icon">
            ✦
        </div>


        <div class="logo-text">

            <h2>
                iNotes
            </h2>

            <span>
                Capture Today • Build Tomorrow
            </span>

        </div>


    </div>



    <div class="nav-right">


        <div class="system-status">

            <span class="status-dot"></span>

            System Online

        </div>


        <button
            class="theme-button"
            onclick="toggleTheme()">

            ◐

        </button>


    </div>


</nav>



<!-- =========================================
     MAIN
========================================= -->

<main class="main-container">



<!-- =========================================
     HERO
========================================= -->

<section class="hero">


    <div class="hero-content">


        <p class="welcome-text">

            ✦ YOUR DIGITAL WORKSPACE

        </p>


        <h1>

            Your ideas.

            <span>
                Organized.
            </span>

        </h1>


        <p class="hero-description">

            Capture your thoughts, manage your ideas
            and keep everything in one beautiful place.

        </p>


        <div class="hero-buttons">


            <a
                href="#create"
                class="hero-button">

                + Create Note

            </a>


            <a
                href="#notes"
                class="secondary-button">

                View Notes

            </a>


        </div>


    </div>



    <!-- GRAPHIC -->

    <div class="hero-graphic">


        <div class="graphic-circle">

            <div class="graphic-inner">

                ✦

            </div>

        </div>


        <div class="graphic-card">


            <div class="mini-icon">

                ✎

            </div>


            <div>

                <strong>
                    Ideas
                </strong>

                <span>
                    Never lose a thought.
                </span>

            </div>


        </div>


    </div>


</section>



<!-- =========================================
     STATISTICS
========================================= -->

<section class="stats">


    <div class="stat-card">


        <div class="stat-icon purple">

            📝

        </div>


        <div>

            <span class="stat-number">

                <?php echo $totalNotes; ?>

            </span>


            <p>
                Total Notes
            </p>

        </div>


    </div>



    <div class="stat-card">


        <div class="stat-icon blue">

            ⚡

        </div>


        <div>

            <span class="stat-number">
                Active
            </span>


            <p>
                Workspace
            </p>

        </div>


    </div>



    <div class="stat-card">


        <div class="stat-icon pink">

            ✨

        </div>


        <div>

            <span class="stat-number">
                24/7
            </span>


            <p>
                Always Available
            </p>

        </div>


    </div>


</section>



<!-- =========================================
     CREATE NOTE
========================================= -->

<section
    class="create-section"
    id="create">


    <div class="section-header">


        <div>

            <p class="small-heading">
                CREATE
            </p>


            <h2>
                Capture a new idea
            </h2>


            <p class="section-description">

                Turn your thoughts into something
                you can remember.

            </p>

        </div>


        <div class="plus-symbol">
            +
        </div>


    </div>



    <form
        action="index.php"
        method="POST"
        class="note-form">


        <div class="input-group">


            <label>
                Note Title
            </label>


            <input
                type="text"
                name="title"
                placeholder="What are you thinking about?"
                required>


        </div>



        <div class="input-group">


            <label>
                Description
            </label>


            <textarea
                name="description"
                rows="4"
                placeholder="Write your thoughts here..."
                required></textarea>


        </div>



        <button
            type="submit"
            class="create-button">

            <span>
                +
            </span>

            Create Note

        </button>


    </form>


</section>



<!-- =========================================
     NOTIFICATIONS
========================================= -->

<?php if ($insert) { ?>

<div class="notification success">


    <div class="notification-icon">
        ✓
    </div>


    <div>

        <strong>
            Note Created!
        </strong>


        <p>
            Your new note has been added successfully.
        </p>

    </div>


</div>

<?php } ?>



<?php if ($update) { ?>

<div class="notification success">


    <div class="notification-icon">
        ✓
    </div>


    <div>

        <strong>
            Note Updated!
        </strong>


        <p>
            Your note has been updated successfully.
        </p>

    </div>


</div>

<?php } ?>



<?php if ($delete) { ?>

<div class="notification deleted">


    <div class="notification-icon">
        ✓
    </div>


    <div>

        <strong>
            Note Deleted!
        </strong>


        <p>
            The note has been removed successfully.
        </p>

    </div>


</div>

<?php } ?>



<!-- =========================================
     NOTES
========================================= -->

<section
    class="notes-section"
    id="notes">


    <div class="notes-header">


        <div>

            <p class="small-heading">
                YOUR COLLECTION
            </p>


            <h2>
                Your Notes
            </h2>


            <p class="section-description">

                <?php echo $totalNotes; ?>

                notes in your collection

            </p>

        </div>



        <!-- SEARCH -->

        <div class="search-box">


            <span>
                🔎
            </span>


            <input
                type="text"
                id="searchNotes"
                placeholder="Search your notes..."
                onkeyup="searchNotes()">


        </div>


    </div>



    <!-- =====================================
         NOTE CARDS
    ====================================== -->

    <div
        class="notes-grid"
        id="notesGrid">


        <?php


        if ($totalNotes == 0) {


        ?>


        <div class="empty-state">


            <div class="empty-icon">
                ✦
            </div>


            <h3>
                No notes yet
            </h3>


            <p>
                Create your first note above.
            </p>


        </div>


        <?php

        }


        while ($row = mysqli_fetch_assoc($result)) {


            $id = $row['sno'];


            $title = htmlspecialchars(
                $row['title'],
                ENT_QUOTES
            );


            $description = htmlspecialchars(
                $row['description'],
                ENT_QUOTES
            );


            $date = date(
                "d M Y",
                strtotime($row['tstamp'])
            );


        ?>


        <!-- =================================
             NOTE CARD
        ================================== -->

        <article
            class="note-card"


            data-title="<?php
                echo strtolower($title);
            ?>"


            data-description="<?php
                echo strtolower($description);
            ?>">


            <div class="card-top">


                <div class="note-badge">

                    ✦ NOTE

                </div>


                <span class="note-time">

                    <?php echo $date; ?>

                </span>


            </div>



            <div class="card-content">


                <h3>

                    <?php echo $title; ?>

                </h3>


                <p>

                    <?php echo $description; ?>

                </p>


            </div>



            <div class="card-footer">


                <span class="note-id">

                    NOTE #<?php echo $id; ?>

                </span>



                <div class="card-actions">


                    <!-- EDIT -->

                    <button
                        type="button"
                        class="action edit"


                        data-id="<?php
                            echo $id;
                        ?>"


                        data-title="<?php
                            echo htmlspecialchars(
                                $row['title'],
                                ENT_QUOTES
                            );
                        ?>"


                        data-description="<?php
                            echo htmlspecialchars(
                                $row['description'],
                                ENT_QUOTES
                            );
                        ?>">

                        ✎

                    </button>



                    <!-- DELETE -->

                    <button
                        type="button"
                        class="action delete"

                        onclick="deleteNote(
                            <?php echo $id; ?>
                        )">

                        🗑

                    </button>


                </div>


            </div>



            <div class="card-glow"></div>


        </article>


        <?php

        }

        ?>


    </div>



    <!-- NO SEARCH RESULT -->

    <div
        id="noSearchResult"
        class="no-search"
        style="display:none;">


        <div class="no-search-icon">
            🔎
        </div>


        <h3>
            No matching notes
        </h3>


        <p>
            Try another search term.
        </p>


    </div>


</section>



</main>



<!-- =========================================
     EDIT MODAL
========================================= -->

<div
    class="modal"
    id="editModal">


    <div
        class="modal-overlay"
        onclick="closeEditModal()">
    </div>



    <div class="modal-content">


        <button
            type="button"
            class="modal-close"
            onclick="closeEditModal()">

            ×

        </button>


        <div class="modal-icon">
            ✎
        </div>


        <p class="small-heading">
            MODIFY NOTE
        </p>


        <h2>
            Edit your note
        </h2>


        <p class="modal-description">

            Update the title or description.

        </p>



        <form
            action="index.php"
            method="POST">


            <input
                type="hidden"
                name="snoEdit"
                id="snoEdit">



            <div class="input-group">


                <label>
                    Note Title
                </label>


                <input
                    type="text"
                    name="titleEdit"
                    id="titleEdit"
                    required>


            </div>



            <div class="input-group">


                <label>
                    Description
                </label>


                <textarea
                    name="descriptionEdit"
                    id="descriptionEdit"
                    rows="5"
                    required></textarea>


            </div>



            <button
                type="submit"
                class="create-button">

                Save Changes

            </button>


        </form>


    </div>


</div>



<!-- =========================================
     FOOTER
========================================= -->

<footer>


    <div class="footer-line"></div>


    <p>
        ✦ Big ideas start with small notes.
    </p>


    <div class="footer-line"></div>


</footer>



<!-- =========================================
     JAVASCRIPT
========================================= -->

<script>


/* =========================================
   LIVE SEARCH
========================================= */

function searchNotes() {


    let search =
        document
        .getElementById("searchNotes")
        .value
        .toLowerCase()
        .trim();


    let cards =
        document.getElementsByClassName(
            "note-card"
        );


    let found = 0;


    for (
        let i = 0;
        i < cards.length;
        i++
    ) {


        let title =
            cards[i].getAttribute(
                "data-title"
            );


        let description =
            cards[i].getAttribute(
                "data-description"
            );


        if (
            title.includes(search) ||
            description.includes(search)
        ) {


            cards[i].style.display =
                "flex";


            found++;


        }

        else {


            cards[i].style.display =
                "none";


        }

    }


    let noResult =
        document.getElementById(
            "noSearchResult"
        );


    if (
        found === 0 &&
        search !== ""
    ) {


        noResult.style.display =
            "block";


    }

    else {


        noResult.style.display =
            "none";


    }

}



/* =========================================
   EDIT
========================================= */

const editButtons =
    document.querySelectorAll(
        ".edit"
    );


editButtons.forEach(
    function(button) {


        button.addEventListener(
            "click",
            function() {


                let id =
                    button.getAttribute(
                        "data-id"
                    );


                let title =
                    button.getAttribute(
                        "data-title"
                    );


                let description =
                    button.getAttribute(
                        "data-description"
                    );


                document
                    .getElementById(
                        "snoEdit"
                    )
                    .value = id;


                document
                    .getElementById(
                        "titleEdit"
                    )
                    .value = title;


                document
                    .getElementById(
                        "descriptionEdit"
                    )
                    .value = description;


                document
                    .getElementById(
                        "editModal"
                    )
                    .classList
                    .add("show");


            }
        );


    }
);



/* =========================================
   CLOSE MODAL
========================================= */

function closeEditModal() {


    document
        .getElementById(
            "editModal"
        )
        .classList
        .remove("show");


}



/* =========================================
   DELETE
========================================= */

function deleteNote(id) {


    let answer =
        confirm(
            "Are you sure you want to delete this note?"
        );


    if (answer) {


        window.location =
            "index.php?delete=" + id;


    }

}



/* =========================================
   DARK / LIGHT MODE
========================================= */

function toggleTheme() {


    document
        .body
        .classList
        .toggle(
            "light-mode"
        );


}



/* =========================================
   ESCAPE KEY
========================================= */

document.addEventListener(
    "keydown",
    function(event) {


        if (
            event.key === "Escape"
        ) {

            closeEditModal();

        }

    }
);


</script>


</body>

</html>