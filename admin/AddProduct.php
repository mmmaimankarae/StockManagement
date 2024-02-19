<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.3/dist/xlsx.full.min.js"></script>
  <title>Document</title>
</head>

<body class="p-3" style="margin-top: 6%">
  <?php include "../components/HeaderAdmin.html"; ?>
  <form action='../admin/ConfirmAddProduct.php' method='post'>
    <div class='container'>
      <div class='row'>
        <div class='col'>
          <div class='col'>
            <img src='' width='500' height='500' class='img-thumbnail shadow-sm'>
            <div class="form-check form-check-inline my-4">
              <input class="form-check-input" type="radio" name="status" id="Active" value="Active" checked>
              <label class="form-check-label" for="inlineRadio1">ลงขายทันที</label>
            </div>
          </div>

          <div class='col'>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="Pending" value="Pending">
              <label class="form-check-label" for="inlineRadio2">กำหนดวันที่ลงขาย</label>
            </div>
          </div>
          <div class='col my-3'>
            <?php include "../admin/DatePicker.html"; ?>
          </div>
        </div>
  
        <div class='col'>
          <div class='mb-3'>
            <label class='my-2'>ชื่อสินค้า</label>
            <div class='col card mx-2'>
              <input type="text" class="form-control" id="proName" name="proName" placeholder="กรอกชื่อสินค้า" required>
            </div>
          </div>
  
          <div class='row'>
            <div class='col'>
              <label class='my-2'>ราคาขายต่อหน่วย (บาท/หน่วย)</label>
              <div class='card mx-2'>
                <input type="number" min='0' step="any" class="form-control" id="pricePerUnit" name="pricePerUnit" placeholder="กรอกราคาสินค้า/หน่วย" required>
              </div>
            </div>
  
            <div class='col'>
              <label class='my-2'>ต้นทุนต่อหน่วย (บาท/หน่วย)</label>
              <div class='card mx-2'>
                <input type="number" min='0' step="any" class="form-control" id="costPerUnit" name="costPerUnit" placeholder="กรอกราคาต้นทุน/หน่วย" required>
              </div>
            </div>
          </div>
  
          <div class='mb-3 my-3'>
            <label class='my-2'>คำอธิบายสินค้า</label>
            <div class='col card mx-2'>
              <textarea class="form-control" id="description" name="description" rows="3" placeholder="กรอกคำอธิบายสินค้า" required></textarea>
            </div>
          </div>
  
          <div class='mb-3'>
            <label class='my-2'>จำนวนสินค้า</label>
            <div class='col card mx-2'>
              <input type="number" min='0' class="form-control" id="stockQty" name="stockQty" placeholder="กรอกจำนวนสินค้า" required>
            </div>
          </div>

          <div class='mb-3'>
            <label class='my-2'>ข้อมูลรูปภาพ</label>
            <div class='col card mx-2'>
              <input type="text" class="form-control" id="imageSource" name="imageSource" placeholder="กรอกลิ้งค์ หรือ เส้นทางของรูปภาพ" required>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class='d-grid gap-2 d-md-flex mx-5 my-3'>
      <button class='btn btn-success ms-auto' type='submit'>ยืนยัน</button>
    </div>
  </form>
</body>

</html>