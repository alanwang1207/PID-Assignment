# PID-Assignment
購物車(買賣內容不限)
1. 管理端

1.1 會員管理 secret

1.1.1 訂單管理:可單看該會員買的項目

1.1.2 會員列表:可顯示、停用會員 (停用該會員則該會員不可登入 或操作)

1.2 商品管理

1.2.1 商品管理:新增刪除修改商品

1.3 報表(加分題，有空再執行)

1.3.1 自由發揮，思考網站營運所需要的報表需可選擇區間查看

2. 會員端

2.1 註冊/登入功能

2.2 產品列表(select * from prod)及購物車功能 (select * union prod table)

2.3 可查看購買的品項

管理員

一般會員

登入驗證分使用者或是管理員

分兩個sql語句

停用功能使用disabled

管理員登入

首頁 有會員管理 商品管理
會員管理頁 訂單管理 會員列表
商品管理頁 商品增刪修

訂單管理頁 

資料庫
使用者
帳號 密碼 dis 
商品 
商品名 數量 金額

購物清單 detail
購買人 購買商品 數量 總金額

建立黑名單表
之後會員管理那邊使用union 

