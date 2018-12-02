UndertaleFont font = Selected as UndertaleFont;
using(StreamWriter writer = new StreamWriter("Fonts\\glyphs_"+font.Name.Content+".csv"))
{
	foreach(var g in font.Glyphs)
	{
		writer.WriteLine(g.Character+";"+g.SourceX+";"+g.SourceY+";"+g.SourceWidth+";"+g.SourceHeight+";"+g.Shift+";"+g.Offset);
	}
}

ScriptMessage(font.Name.Content+" exported!");