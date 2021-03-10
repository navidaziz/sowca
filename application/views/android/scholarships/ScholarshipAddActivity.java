
public class ScholarshipAddActivity extends AppCompatActivity {
	
	private text scholarship_name;
				private text scholarship_detail;
				private EditText scholarship_value;
				private Button btn_add_scholarships;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_add_scholarship);
		
		scholarship_name = (text)findViewById(R.id.scholarship_name);
				scholarship_detail = (text)findViewById(R.id.scholarship_detail);
				scholarship_value = (EditText)findViewById(R.id.scholarship_value);
				btn_add_scholarships = (Button)findViewById(R.id.btn_add_scholarships);
		
		
btn_add_scholarships.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //do your code here
				final String form_scholarship_name = scholarship_name.getText().toString();
				final String form_scholarship_detail = scholarship_detail.getText().toString();
				final String form_scholarship_value = scholarship_value.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(ScholarshipAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/scholarship/save_data", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(ScholarshipAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(ScholarshipAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("scholarship_name", form_scholarship_name);
				params.put("scholarship_detail", form_scholarship_detail);
				params.put("scholarship_value", form_scholarship_value);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		

     }

}
