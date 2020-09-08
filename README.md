# PID-Assignment
購物車(買賣內容不限)
1. 管理端

1.1 會員管理 

1.1.1 訂單管理:可單看該會員買的項目

1.1.2 會員列表:可顯示、停用會員 (停用該會員則該會員不可登入 或操作)

1.2 商品管理

1.2.1 商品管理:新增刪除修改商品

1.3 報表(加分題，有空再執行)

1.3.1 自由發揮，思考網站營運所需要的報表需可選擇區間查看

2. 會員端

2.1 註冊/登入功能

2.2 產品列表及購物車功能

2.3 可查看購買的品項

# 製作流程
- 建立資料表
## server端
- 建立商品管理頁及功能(增 刪 修)
- 建立訂單管理頁
- 建立會員頁及功能(增 刪 修)
- 建立黑名單功能
- 訂單查詢功能
- 驗證帳號唯一
## client端
- 建立會員首頁及功能(增 刪 修)
- 購物車功能(增 刪)
- 建立訂單功能


總共建立四張表

分別是user prod cart detail

Login

使用者登入畫面做驗證 如果帳號id是1就跳到管理頁面 其他的則是跳到首頁
驗證方式使用select語句查詢user表 接著使用query搭配num rows和fetch assoc 檢查是否有這筆資料以及將相關資料存到session

index

介面使用bootstrap的輪播圖 下拉菜單 商品排列使用卡片
首頁顯示的是暫存數 避免直接動到產品數本身 如果是非會員點擊加入購物車會跳轉到登入頁
商品顯示使用select語句fetch出prod表的內容 圖片則是放在本地端
輸入的數量不能是負的以及如果數量為０則顯示庫存不足
搜尋商品使用的事select搭配like語句下去作查詢

Cart

購物車頁面使用select語句搭配join撈出cart表目前的商品 依據userＩＤ 
頁面會顯示加入購物車的商品以及目前的總價 
如果按下刪除則會刪除當前的產品 以及更新產品表的暫存數
如果按下送出訂單則是會建立訂單表
這裡建立訂單的方式是使用新訂單等於舊訂單id+1 因為要可以重複所以不設定auto increment
建立後更新產品表真實數量以及刪除購物車的清單

Detail

訂單分為訂單總頁及詳細訂單頁
訂單總頁為所有訂單的訂單編號 訂購日期 按下更多會再多出五個
可改成做上一頁下一頁

訂單詳情頁則顯示詳細購買資訊

server端

Admin

分別有會員管理以及商品管理
會員管理有訂單管理以及會員列表
訂單管理使用select detail顯示所有訂單 以及有增加輸入商品名以及購買人做查詢的動作

會員列表則是可做黑名單控制以及查看該會員購買紀錄 有在user表新增dis欄位做驗證

商品管理則是簡單的增刪修 圖片的部分則是無修改 只能從新增那邊動作 修改商品名也會跟著修改圖檔名
