<?php
require_once("../../settings/db_class.php");

class admin_staff_class extends db_connection {

    // Add staff
    public function addstaff($title, $brand, $category, $price, $description, $image, $keywords) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $brand = mysqli_real_escape_string($this->db_conn(), $brand);
        $category = mysqli_real_escape_string($this->db_conn(), $category);
        $price = mysqli_real_escape_string($this->db_conn(), $price);
        $description = mysqli_real_escape_string($this->db_conn(), $description);
        $keywords = mysqli_real_escape_string($this->db_conn(), $keywords);

        $sql = "INSERT INTO products (product_title, product_brand, product_cat, product_price, product_desc, product_image, product_keywords) 
                VALUES ('$title', '$brand', '$category', '$price', '$description', '$image', '$keywords')";

        return $this->db_query($sql);
    }

    // Delete a staff by id
    public function deletestaff($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "DELETE FROM user_table WHERE user_id = '$id'";
        return $this->db_query($sql);
    }

    // Get all staff records
    public function getstaffs() {
        $sql = "SELECT * FROM staff_table";
        return $this->db_fetch_all($sql);
    }

    // Get staff information by id
    public function getstaffsbyID($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT * FROM staff_table WHERE staff_id = '$id'";
        return $this->db_fetch_all($sql);
    }

    // Update product
    public function updateProduct($id, $title, $category, $brand, $price, $description, $image, $keywords) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $category = mysqli_real_escape_string($this->db_conn(), $category);
        $brand = mysqli_real_escape_string($this->db_conn(), $brand);
        $price = mysqli_real_escape_string($this->db_conn(), $price);
        $description = mysqli_real_escape_string($this->db_conn(), $description);
        $image = mysqli_real_escape_string($this->db_conn(), $image);
        $keywords = mysqli_real_escape_string($this->db_conn(), $keywords);

        $sql = "UPDATE products SET

                product_title = '$title',
                product_cat = '$category',
                product_brand = '$brand',
                product_price = '$price',
                product_desc = '$description',
                product_image = '$image',
                product_keywords = '$keywords'
                WHERE product_id = '$id'";

        return $this->db_query($sql);
    }
}
?>
