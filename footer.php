<!-- footer.php -->
<footer style="background-color: rgba(0,0,0,.7); line-height: 2vh; padding: 20px 0; margin-top: 0px; width: 100%;">
    <p style="text-align: center; color: white; padding: 0px; margin: 0;">
        &copy; <?= date('Y'); ?>, Copyright Ivan :)
    </p>
    <p style="text-align: center; color: white; padding: 10px; margin: 0;">Informasi lebih lanjut silakan hubungi dokter spesialis kandungan.</p>
</footer>

<!-- BOOTSTRAP OFFLINE -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->


<script src="<?= $base_url ?>/js/bootstrap.bundle.min.js"></script> 
<!-- SCRIPT NAVBAR ACTIVE -->
<script>
const sections = document.querySelectorAll("section");
const navLinks = document.querySelectorAll(".nav-link");

window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach(section => {
        const sectionTop = section.offsetTop - 120;
        if (window.pageYOffset >= sectionTop) {
            current = section.getAttribute("id");
        }
    });

    navLinks.forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("href") === "#" + current) {
            link.classList.add("active");
        }
    });
});
</script>

</body>
</html>