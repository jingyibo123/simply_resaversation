    <!-- 父层 -->  
    <div id="wapper">  
        <!-- 主要内容 -->  
        <div id="main-content">  11
        </div>  
        <!-- 页脚 -->  
        <div id="footer"> 22 
        </div>  
    </div>  
<style>
    #wapper{  
        position: relative;   /*重要！保证footer是相对于wapper位置绝对*/  
        height: auto;          /* 保证页面能撑开浏览器高度时显示正常*/  
        min-height: 100%  /* IE6不支持，IE6要单独配置*/  
    }  
    #footer{  
       position: fixed;  bottom: 0; /* 关键 */  
       left:0; /* IE下一定要记得 */  
       height: 60px;         /* footer的高度一定要是固定值*/  
    }  
    #main-content{  
       padding-bottom: 60px; /*重要！给footer预留的空间*/  
    } 
	</style>