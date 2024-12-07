var WizardDemo = function () {
	$("#m_wizard");
	var e, r, i = $("#m_form");
	return {
		init: function () {
			var n;
			$("#m_wizard"), i = $("#m_form"), (r = new mWizard("m_wizard",{ 
				startStep: 1
			})).on("beforeNext", function (r) {
				!0 !== e.form() && r.stop()
			}), r.on("change", function (e) {
				mUtil.scrollTop()
			}), r.on("change", function (e) {
				1 === e.getStep()
			}), e = i.validate({
				ignore: ":hidden",
				invalidHandler: function (e, r) {
					mUtil.scrollTop()
				},
				submitHandler: function (e) {
                    e.submit();
                }
			})
		}
	}
}();
jQuery(document).ready(function () {
	WizardDemo.init()
});